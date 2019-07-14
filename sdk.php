<?
class UniCoinClient{
  private $merchant_id = 0;
  private $curl = true;
  protected const API_HOST = "https://uc.simbrex.com/api/merchant/";
  private $key = "";
  public function __construct($merchant_id, $key){
    if(version_compare('7.0.0', phpversion()) === 1) {
      $this->curl = false;
    }
    $this->merchant_id = $merchant_id;
    $this->key = $key;
  }
  public function dump(){
    return [$this->key, $this->merchant_id];
  }
  private function build_query($array){
    $result = "";
    $i = 0;
    foreach($array as $key => $value){
      if($i = count($array)){
        $result = $result.$key."=".$value;
      }else{
        $result = $result.$key."=".$value."&";
      }
      $i++;
    }
    return $result;
  }
  private function request(string $method, $params) {
    $url = self::API_HOST.$method.".php";
    $params['merchant_id'] = $this->merchant_id;
    $params['key']= $this->key;
    if($this->curl && function_exists("curl_init")){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type:multipart/form-data"
      ));
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      $result = json_decode(curl_exec($ch), True);
      curl_close($ch);
    }else{
      $result = json_decode(file_get_contents($url, true, stream_context_create(array(
          'http' => array(
              'method'  => 'POST',
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'content' => http_build_query($params)
          )
      ))), true);
    }
    if($result['status'] == "succes"){
      return $result;
    }else{
      error_log("UniCoinClient Error with number ".$result['error']['code']." - ".$result['error']['description']."", 0);
      return $result;
    }
  }
  public function getBalance(){
    $result = $this->request("getBalance", array());
    return $result;
  }
  public function sendPayment($to_id, $sum, $code = false){
    $code = $code?$code:rand(-20000, 20000);
    $result = $this->request("transfer", array('sum' => $sum, 'code' => $code,'to' => $to_id));
    return $result;
  }
  public function getHistory($count = 1000, $offset = 0){
    $result = $this->request("getHistory", array('count' => $count, 'offset' => $offset));
    return $result;
  }
  public function getPaymentLink($sum = 0, $payload = false){
    $code = $payload?$payload:rand(-200000000, 200000000);
    $id = $this->merchant_id;
    $url = "vk.com/app7037638#pay_".$id."_".$sum."_$code";
    return $url;
  }
}
?>
