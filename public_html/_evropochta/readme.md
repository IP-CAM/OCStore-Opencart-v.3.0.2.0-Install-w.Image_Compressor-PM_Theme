# Список отделений "Европочта"
Json запрашивается здесь - https://evropochta.by/about/offices/
страница отправляет fetch запрос за json на https://rest.eurotorg.by/10301/Json?What=Postal.OfficesOut

Обновлять либо вручную (пока так), либо автоматизировать с помощью cron.


## Формат:
```json
{
  "Table": [
    {
      "WarehouseId": "70530010",
      "WarehouseName": "Отделение № 117, г. Воложин, ул. Советская 95",
      "Longitude": "26.513",
      "Latitude": "54.0949",
      "Address1Id": "887111",
      "Info1": "Режим работы: 10:00-19:00 Обед: 14:00-15:00 Выходные: вс,пн",
      "Address7Id": "79",
      "Address7Name": "МИНСКАЯ ОБЛАСТЬ",
      "isNew": "1",
      "Note": ""
    }
  ]
}
```