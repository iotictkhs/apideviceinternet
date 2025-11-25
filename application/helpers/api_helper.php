// application/helpers/api_helper.php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Helper untuk response API standar JSON
 */

if (!function_exists('stdPrintJson')) {
    /**
     * Cetak respon JSON standar untuk API
     * 
     * @param array $data Data yang akan dikirim
     * @param int $code HTTP status code (default: 200)
     */
    function stdPrintJson($data, $code = 200)
    {
        // Bersihkan output buffer (jaga-jaga)
        if (ob_get_length()) ob_clean();

        // Set header dan status code
        header('Content-Type: application/json');
        http_response_code($code);

        // Bentuk struktur JSON
        $response = [
            'timestamp' => date('Y-m-d H:i:s'),
            'status' => isset($data['status']) ? $data['status'] : 'success',
            'message' => isset($data['message']) ? $data['message'] : '',
            'data' => isset($data['data']) ? $data['data'] : ''
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
}

