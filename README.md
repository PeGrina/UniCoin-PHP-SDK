# UniCoin-PHP-SDK
Документация для работы с SDK для UniCoin на PHP

Подключение - Скачайте файл sdk.php и подключите его как показано ниже.
<pre>
  include "sdk.php";
  $unicoin = new UniCoinClient(MERCHANT_ID, KEY);
</pre>
Здесь MERCHANT_ID это ID мерчанта, а KEY ключ мерчанта.
Для того чтобы узнать баланс просто пропишите:
<pre>
  $balance = $unicoin->getBalance(); 
</pre>
Возвращается баланс текущего мерчанта.
<pre>
  $unicoin->sendPayment(USER_ID, SUM, CODE);
</pre>
Отправляет Uni Коины пользователю под USER_ID в количестве SUM, CODE необязательный параметр, можно его и не указывать. 
<pre>
  $history = $unicoin->getHistory(COUNT, OFFSET);
</pre>
Возвращает Историю переводов текущего мерчанта. И COUNT и OFFSET необязательные параметры
<pre>
  $paymentLink = $unicoin->getPaymentLink(SUM, CODE);
</pre>
Возвращает ссылку для оплаты в магазин если хотите указать фиксированную сумму напишите ее в SUM иначе оставьте это поле пустым или со значением 0. CODE необязательный параметр.
Если во время работы возникнут ошибки они будут высвечены в логе ошибок.
