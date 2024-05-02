<?php

namespace Jobins\MagikaFileValidator;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Process;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidateFileTypeRule implements ValidationRule
{
    private array $typeMapping = [
        'Adobe Illustrator Artwork'                      => 'ai',
        'Android package'                                => 'apk',
        'Apple property list'                            => 'plist',
        'Assembly'                                       => 'asm',
        'ASP source'                                     => 'asp',
        'DOS batch file'                                 => 'bat',
        'BMP image data'                                 => 'bmp',
        'bzip2 compressed data'                          => 'bz2',
        'C source'                                       => 'c',
        'Microsoft Cabinet archive data'                 => 'cab',
        'Windows Catalog file'                           => 'cat',
        'MS Windows HtmlHelp Data'                       => 'chm',
        'Intel 80386 COFF'                               => 'coff',
        'Google Chrome extension'                        => 'crx',
        'C# source'                                      => 'cs',
        'CSS source'                                     => 'css',
        'CSV document'                                   => 'csv',
        'Debian binary package'                          => 'deb',
        'Dalvik dex file'                                => 'dex',
        'A directory'                                    => '', // No extension for directories
        'Apple disk image'                               => 'dmg',
        'Microsoft Word CDF document'                    => 'doc',
        'Microsoft Word 2007+ document'                  => 'docx',
        'ELF executable'                                 => '', // No standard extension for ELF executables
        'Windows Enhanced Metafile image data'           => 'emf',
        'RFC 822 mail'                                   => 'eml',
        'Empty file'                                     => '', // No extension for empty files
        'EPUB document'                                  => 'epub',
        'FLAC audio bitstream data'                      => 'flac',
        'GIF image data'                                 => 'gif',
        'Golang source'                                  => 'go',
        'gzip compressed data'                           => 'gz',
        'MS Windows help'                                => 'hlp',
        'HTML document'                                  => 'html',
        'MS Windows icon resource'                       => 'ico',
        'INI configuration file'                         => 'ini',
        'MS Windows Internet shortcut'                   => 'url',
        'ISO 9660 CD-ROM filesystem data'                => 'iso',
        'Java archive data (JAR)'                        => 'jar',
        'Java source'                                    => 'java',
        'Java compiled bytecode'                         => 'class',
        'JavaScript source'                              => 'js',
        'JPEG image data'                                => 'jpeg',
        'JSON document'                                  => 'json',
        'LaTeX document'                                 => 'tex',
        'Lisp source'                                    => 'lisp',
        'MS Windows shortcut'                            => 'lnk',
        'M3U playlist'                                   => 'm3u',
        'Mach-O executable'                              => '', // No standard extension for Mach-O executables
        'Makefile source'                                => 'mk',
        'Markdown document'                              => 'md',
        'MHTML document'                                 => 'mht',
        'MP3 media file'                                 => 'mp3',
        'MP4 media file'                                 => 'mp4',
        'MS Compress archive data'                       => '??', // Unsure of the extension, need clarification
        'Microsoft Installer file'                       => 'msi',
        'Windows Update Package file'                    => 'mum',
        'ODEX ELF executable'                            => 'odex',
        'OpenDocument Presentation'                      => 'odp',
        'OpenDocument Spreadsheet'                       => 'ods',
        'OpenDocument Text'                              => 'odt',
        'Ogg data'                                       => 'ogg',
        'MS Outlook Message'                             => 'msg',
        'pcap capture file'                              => 'pcap',
        'PDF document'                                   => 'pdf',
        'PE executable'                                  => 'exe',
        'PEM certificate'                                => 'pem',
        'Perl source'                                    => 'pl',
        'PHP source'                                     => 'php',
        'PNG image data'                                 => 'png',
        'PostScript document'                            => 'ps',
        'Powershell source'                              => 'ps1',
        'Microsoft PowerPoint CDF document'              => 'ppt',
        'Microsoft PowerPoint 2007+ document'            => 'pptx',
        'Python source'                                  => 'py',
        'Python compiled bytecode'                       => 'pyc',
        'RAR archive data'                               => 'rar',
        'Resource Description Framework document (RDF)'  => 'rdf',
        'RedHat Package Manager archive (RPM)'           => 'rpm',
        'ReStructuredText document'                      => 'rst',
        'Rich Text Format document'                      => 'rtf',
        'Ruby source'                                    => 'rb',
        'Rust source'                                    => 'rs',
        'Scala source'                                   => 'scala',
        '7-zip archive data'                             => '7z',
        'Shell script'                                   => 'sh',
        'Smali source'                                   => 'smali',
        'SQL source'                                     => 'sql',
        'Squash filesystem'                              => 'sqsh',
        'SVG Scalable Vector Graphics image data'        => 'svg',
        'Macromedia Flash data'                          => 'swf',
        'Symbolic link to'                               => '', // No extension for symbolic links
        'Symbolic link (textual representation)'         => '', // No extension for symbolic links
        'POSIX tar archive'                              => 'tar',
        'Targa image data'                               => 'tga',
        'TIFF image data'                                => 'tiff',
        'BitTorrent file'                                => 'torrent',
        'TrueType Font data'                             => 'ttf',
        'Generic text document'                          => 'txt',
        'Unknown binary data'                            => '', // No extension for unknown data
        'MS Visual Basic source (VBA)'                   => 'vba',
        'Waveform Audio file (WAV)'                      => 'wav',
        'WebM data'                                      => 'webm',
        'WebP data'                                      => 'webp',
        'Windows Registry text'                          => 'reg',
        'Windows metafile'                               => 'wmf',
        'XAR archive compressed data'                    => 'xar',
        'Microsoft Excel CDF document'                   => 'xls',
        'Microsoft Excel 2007+ document (binary format)' => 'xlsb',
        'Microsoft Excel 2007+ document'                 => 'xlsx',
        'XML document'                                   => 'xml',
        'Compressed installation archive (XPI)'          => 'xpi',
        'XZ compressed data'                             => 'xz',
        'YAML source'                                    => 'yaml',
        'Zip archive data'                               => 'zip',
        'zlib compressed data'                           => 'zlib',
    ];

    private array $validTypes;

    public function __construct(array $validTypes)
    {
        $this->validTypes = $validTypes;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( !$value instanceof UploadedFile ) {
            $fail('validation.file')->translate();
        }

        $extension = $this->getFileExtension($value->getPathname());

        if ( !in_array($extension, $this->validTypes) ) {
            $fail('validation.mimes')->translate([
                'values' => implode(", ", $this->validTypes)
            ]);
        }
    }

    private function getFileExtension(string $path): ?string
    {
        $magikaPath = config('app.magika_binary_path');
        $result     = Process::path($magikaPath)->run("./magika $path");
        $fileLabel  = $this->parseFileLabel($result->output());

        return $this->getExtensionFromLabel($fileLabel);
    }

    private function parseFileLabel($output): ?string
    {
        if ( preg_match('/:\s*(.*?)\s*\(confidence:/i', $output, $matches) ) {
            return trim($matches[1]);
        }

        return null;
    }

    private function getExtensionFromLabel($fileTypeLabel): ?string
    {
        return $fileTypeLabel ? ($this->typeMapping[$fileTypeLabel] ?? null) : null;
    }
}

