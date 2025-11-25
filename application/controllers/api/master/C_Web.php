<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');

function debug($value = '')
{
  echo '<pre>';
  print_r($value);
  die;
}

/*  
fungsi C_Web
- ngelola permintaan API baik get maupun post
- fungsi lain e buat mengambil, memproses, dan ngembaliin data sek ada di M_Web
*/

class C_Web extends CI_Controller
{
  public $api, $input, $M_Web;
  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->library('encrypt');
  }

  /* 
  API sek biasane tak buat iku ada beberapa fungsi. 
    - post/save : digunain buat nyimpen data ke database dari program arduino
    - get/monitoring : ini buat monitoring data apa aja sek ada di database
    - get/lastData : buat ngambil data terakhir yg ada di database sek dibuat
    - post/update : buat update data dari post/save yang dibuat

  ini tergantung dari kebutuhan juga, kadang engga semuane dipake
  */
  public function save($data)
  {
    try {
      $in = file_get_contents('php://input');
      $decoded = json_decode($in, true);

      if (empty($decoded)) {
          $decoded = $this->input->post();
      }

      if (empty($decoded)) {
          stdPrintJson([
              'status' => 'error',
              'message' => 'Data input tidak boleh kosong'
          ], 400);
      }

      // 📋 Definisikan aturan validasi di sini
      $rules = [
        'longitude' => ['required' => true, 'type' => 'string'],
        'latitude' => ['required' => true, 'type' => 'string'],
        'voltage' => ['required' => true, 'type' => 'string'],
        'accurate' => ['required' => true, 'type' => 'string'],
        'waktu_rtc' => ['required' => true, 'type' => 'string'],
      ];

      // ✅ Jalankan validasi -> tiap fiel jika belum di isi(!isset) maka akan print ini
      foreach ($rules as $field => $rule) {
        // Cek field wajib diisi
        if (!isset($decoded[$field]) || $decoded[$field] === '') {
            stdPrintJson([
                'status' => 'error',
                'message' => "Field '{$field}' wajib diisi."
            ], 422);
        }

        // Cek tipe data
        $value = $decoded[$field];
        $type = $rule['type'];

        //ini untuk memberikan validasi setiap tipe data yang digunakan-> disini kita validasi int & string
        switch ($type) {
          case 'int':
            if (!is_numeric($value)) {
                stdPrintJson([
                    'status' => 'error',
                    'message' => "Field '{$field}' harus berupa angka."
                ], 422);
            }
            break;

          case 'string':
            if (!is_string($value)) {
                stdPrintJson([
                    'status' => 'error',
                    'message' => "Field '{$field}' harus berupa teks (string)."
                ], 422);
            }
            break;
          default:
              // kalau tipe tidak dikenali, abaikan
            break;
        }
      }

      // ✅ Kalau lolos semua validasi, simpan ke database
      $response = $this->M_Web->save($decoded);
      stdPrintJson($response, 201);

    } catch (Exception $e) {
        stdPrintJson([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
  }


  public function update()
  {
    try {
      $in = file_get_contents('php://input');
      $decoded = json_decode($in, true);

      if (empty($decoded)) {
          $decoded = $this->input->post();
      }

      if (empty($decoded)) {
          stdPrintJson([
              'status' => 'error',
              'message' => 'Data input tidak boleh kosong'
          ], 400);
      }

      // 🆔 Pastikan ada field id
      if (empty($decoded['id'])) {
          stdPrintJson([
              'status' => 'error',
              'message' => 'Field id wajib diisi untuk update data.'
          ], 422);
      }

      // 📋 Aturan validasi field (sesuaikan dengan tipe data agar masuk ke validasi tipe data)
      $rules = [
        'longitude' => ['required' => true, 'type' => 'string'],
        'latitude' => ['required' => true, 'type' => 'string'],
        'voltage' => ['required' => true, 'type' => 'string'],
        'accurate' => ['required' => true, 'type' => 'string'],
        'waktu_rtc' => ['required' => true, 'type' => 'string'],
      ];

      // ✅ Jalankan validasi -> tiap fiel jika belum di isi(!isset) maka akan print ini
      foreach ($rules as $field => $rule) {
        if (!isset($decoded[$field]) || $decoded[$field] === '') {
          stdPrintJson([
              'status' => 'error',
              'message' => "Field '{$field}' wajib diisi."
          ], 422);
        }

        $value = $decoded[$field];
        $type = $rule['type'];

        //ini untuk memberikan validasi setiap tipe data yang digunakan-> disini kita validasi int & string
        switch ($type) {
          case 'int':
            if (!is_numeric($value)) {
              stdPrintJson([
                  'status' => 'error',
                  'message' => "Field '{$field}' harus berupa angka."
              ], 422);
            }
            break;

          case 'string':
            if (!is_string($value)) {
              stdPrintJson([
                  'status' => 'error',
                  'message' => "Field '{$field}' harus berupa teks (string)."
              ], 422);
            }
            break;
        }
      }

      // 🧭 Cek apakah data dengan id tsb ada di DB dan kasih validasi juga
      $existing = $this->M_Web->getById($decoded['id']);
      if (!$existing) {
        stdPrintJson([
            'status' => 'error',
            'message' => 'Data dengan ID tersebut tidak ditemukan.'
        ], 404);
      }

      // ✅ Jalankan update lewat model
      $response = $this->M_Web->update($decoded['id'], $decoded);
      stdPrintJson($response, 200);

  } catch (Exception $e) {
      stdPrintJson([
          'status' => 'error',
          'message' => 'Terjadi kesalahan: ' . $e->getMessage()
      ], 500);
    }
  }

      // ✅ Ambil semua data
      // Disini kita langsung ngarahin ke M_Web dan ngasih validasi data pakai try catch
    public function getAllData()
    {
        try {
            $data = $this->M_Web->getAllData();

            if (empty($data)) {
                stdPrintJson([
                    'status' => 'success',
                    'message' => 'Belum ada data yang tersimpan',
                    'data' => []
                ], 200);
            }

            stdPrintJson([
                'status' => 'success',
                'message' => 'Data berhasil diambil',
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            stdPrintJson([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    // ✅ Ambil data pertama
    // Disini kita langsung ngarahin ke M_Web dan ngasih validasi data pakai try catch
    public function getFirstData()
    {
        try {
            $data = $this->M_Web->getFirstData();

            if (!$data) {
                stdPrintJson([
                    'status' => 'success',
                    'message' => 'Belum ada data di database',
                    'data' => null
                ], 200);
            }

            stdPrintJson([
                'status' => 'success',
                'message' => 'Data pertama berhasil diambil',
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            stdPrintJson([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    // ✅ Ambil data terakhir
    // Disini kita langsung ngarahin ke M_Web dan ngasih validasi data pakai try catch
    public function getLastData()
    {
        try {
            $data = $this->M_Web->getLastData();

            if (!$data) {
                stdPrintJson([
                    'status' => 'success',
                    'message' => 'Belum ada data di database',
                    'data' => null
                ], 200);
            }

            stdPrintJson([
                'status' => 'success',
                'message' => 'Data terakhir berhasil diambil',
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            stdPrintJson([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
