<?php

namespace App\Jobs;

use App\Services\Gallery\GalleryDbService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class CompressVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $uploadFilePath,
        public string $path,
        public int $id,
    ) {}

    public function handle(GalleryDbService $galleryDbService): void
    {
        set_time_limit(0);
        $input = storage_path('app/public/' . $this->uploadFilePath);
        $fileName = pathinfo($this->uploadFilePath, PATHINFO_FILENAME);
        $compressedName = 'compressed_' . $fileName . '.mp4';
        $outputPath = $this->path . '/' . $compressedName;
        $output = storage_path('app/public/' . $outputPath);

        $process = new Process([
            '/usr/bin/ffmpeg',
            '-i', $input,
            '-vf', 'scale=1280:-2',
            '-c:v', 'libx264',
            '-crf', '32',
            '-preset', 'veryfast',
            '-c:a', 'aac',
            '-b:a', '96k',
            '-movflags', '+faststart',
            $output,
            '-y'
        ]);

        $process->setTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception($process->getErrorOutput());
        }

        if (file_exists($output)) {
            @unlink($input);
        }

        $galleryDbService->updateByTypeId($this->id,[
            'path' => $outputPath,
        ]);
    }
}
