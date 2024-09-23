<?php

namespace App\Livewire;

use Livewire\Component;

class ServerStatus extends Component
{
    public $latency = null;
    public $showPing = false; // Menambahkan variabel untuk mengontrol tampilan ping
    public $downloadSpeed = null;
    public function ping()
    {
        if ($this->showPing) {
            $startTime = microtime(true);

            // Ping server
            $file_headers = @get_headers('http://localhost');
            $endTime = microtime(true);

            if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $this->latency = 'Server tidak tersedia';
            } else {
                $this->latency = round(($endTime - $startTime) * 1000, 2) . ' ms';
            }

            // Ukur kecepatan download
            $startTime = microtime(true);
            $data = file_get_contents('C:\xampp\htdocs\Proyek_PPC\public\test.zip');
            $endTime = microtime(true);

            if ($data === false) {
                $this->downloadSpeed = 'Gagal mengunduh file';
            } else {
                $fileSize = strlen($data);
                $downloadTime = $endTime - $startTime;
                $downloadSpeed = round($fileSize / $downloadTime / 1024, 2); // Kecepatan dalam KB/s

                // Konversi ke MB/s atau GB/s jika diperlukan
                if ($downloadSpeed > 1024 * 1024) { // 1024 MB = 1 GB
                    $downloadSpeed = round($downloadSpeed / 1024 / 1024, 2) . ' Gb/s';
                } elseif ($downloadSpeed > 1024) {
                    $downloadSpeed = round($downloadSpeed / 1024, 2) . ' Mb/s';
                } else {
                    $downloadSpeed = $downloadSpeed . ' Kb/s';
                }

                $this->downloadSpeed = $downloadSpeed;
            }
        }
    }

    public function togglePing()
    {
        $this->showPing = !$this->showPing;

        if (!$this->showPing) {
            $this->latency = null;
            $this->downloadSpeed = null; // Reset downloadSpeed saat ping dimatikan
        }
    }
    public function render()
    {
        return view('livewire.server-status');
    }
}
