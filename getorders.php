<?php

$curl = curl_init();

curl_setopt_array($curl, [
  //CURLOPT_URL => "https://novomodecol.vtexcommercestable.com.br/api/oms/pvt/orders?f_creationDate=creationDate%3A%5B2022-01-31T00%3A00%3A00.000Z%20TO%202022-01-31T23%3A59%3A59.999Z%5D&f_hasInputInvoice=false",
  //CURLOPT_URL => "https://novomodecol.vtexcommercestable.com.br/api/oms/pvt/orders/1326300538777-01",
  //CURLOPT_URL => "https://novomodecol.vtexcommercestable.com.br/api/catalog/pvt/product/20506724",
  //CURLOPT_URL => "https://novomodecol.vtexcommercestable.com.br/api/catalog_system/pvt/products/productgetbyrefid/BBW550SBVERDECLARO",
  CURLOPT_URL => "https://novomodecol.vtexcommercestable.com.br/api/catalog_system/pvt/products/GetProductAndSkuIds",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30, 
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Content-Type: application/json",
    "X-VTEX-API-AppKey: vtexappkey-novomodecol-IIDAYJ",
    "X-VTEX-API-AppToken: DGZBJASUJFNJGMFGJGDKTNZNPISUAFTXTFGUPMBBPOKAGMFVXUIJGOFPHMLAHYUEMQQBFKRXECVFCYHDCXXFXKREZQNDABTRUGOQWEQMCKEETAMIEIXKAOHCYMBOWOWD"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo '<pre>'; print_r($response); echo '</pre>';
}