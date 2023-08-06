/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import Planification from './components/Planification.vue';
app.component('planification', Planification);


$.loadWeekData = function (params, url) {
    var week_data = $("#planif1254879856hyuook5454_form").serializeArray()
    var obj_w = {};
    obj_w["statuts"] = [];
    $.map(week_data, function (input) {
        if (input.name == "statuts[]") {
            obj_w["statuts"][input.value] = input.value;
        }
        obj_w[input.name] = input.value;
    });
    
    $.map(params, function (val, key) {
        obj_w[key] = val;
        
    });
    
    ajax_get(obj_w, url, (res) => {
        if (res.content) {
            $.map(res.content, function (tem, w) {
                $(`#${w}_box`).addClass("out-dimmer");
                $(`#${w}_box`).html(tem);
            });
        } else if (res.weeks) {
            $.map(res.weeks, function (_week) {
                $.loadWeekData(
                    {
                        week: _week,
                        async: true,
                    },
                    "/commande/planif/week"
                );
            });
        } else {
            console.log("server error !");
        }
    },
        (err) => {
            console.log("server error !");
        }
    );
};

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
