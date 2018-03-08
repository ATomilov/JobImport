<?php
function doGetAdvertisementById( $id ) {
  $data_array = array();
  try {
    $test_request = new tlj_Queries;
    $result = $test_request->getAdvertisementById( $id );
    $data_array = array(
      'success' => true,
      'data' => $result
    );
  }
  catch (Exception $e) {
    $data_array = array(
      'success' => false
    );
  }
  return $data_array;
}

echo json_encode(doGetAdvertisementById(1));