<?php

namespace App\Http;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jasny\SSO\Broker;
use Jasny\SSO\Broker\NotAttachedException;

class CCBroker extends Broker
{
    public function __construct()
    {
        parent::__construct(env('SSO_SERVER_URL'), env('SSO_BROKER_ID'), env("SSO_BROKER_SECRET"));
        $this->attach(true);
    }

    protected function request($method, $command, $data = null)
    {
        if (!$this->isAttached()) {
            throw new NotAttachedException('No token');
        }
        $url = $this->getRequestUrl($command, !$data || $method === 'POST' ? [] : $data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Authorization: Bearer ' . $this->getSessionID()]);

        if ($method === 'POST' && !empty($data)) {
            $post = is_string($data) ? $data : http_build_query($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $response = curl_exec($ch);
        if (curl_errno($ch) != 0) {
            $message = 'Server request failed: ' . curl_error($ch);
            throw new Exception($message);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        list($contentType) = explode(';', curl_getinfo($ch, CURLINFO_CONTENT_TYPE));

        $data = json_decode($response, true);
        if ($httpCode == 403) {
            $this->clearToken();
            throw new NotAttachedException($data['error'] ?: $response, $httpCode);
        }

        return $data;
    }
    public function loginUser($username, $password)
    {
        try {
            $this->login($username, $password);
        } catch (NotAttachedException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    public function loginCurrentUser($returnUrl = '/home')
    {
        if (isset(request()->userAuth)) {
            $user = User::where('usersso', request()->userAuth)->first();
            if ($user) {
                Auth::login($user);
                return redirect()->to(\session()->get('newUrl'));
            } else {
                $this->getUserInfo();
            }
        } else {
            $this->getUserInfo();
        }
    }
}
