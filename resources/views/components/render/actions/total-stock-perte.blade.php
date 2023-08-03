@dump($_model->stocks())
{{ $_model->stocks()->sum('qte') }}
