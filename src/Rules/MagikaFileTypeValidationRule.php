<?php

namespace Jobins\MagikaFileValidator\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class MagikaFileTypeValidationRule implements Rule
{
    /** @var string */
    protected string $attribute;

    /** @var array */
    protected array $validTypes;

    /** @var array|string[] */
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
        'A directory'                                    => '',
        'Apple disk image'                               => 'dmg',
        'Microsoft Word CDF document'                    => 'doc',
        'Microsoft Word 2007+ document'                  => 'docx',
        'ELF executable'                                 => '',
        'Windows Enhanced Metafile image data'           => 'emf',
        'RFC 822 mail'                                   => 'eml',
        'Empty file'                                     => '',
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
        'Mach-O executable'                              => '',
        'Makefile source'                                => 'mk',
        'Markdown document'                              => 'md',
        'MHTML document'                                 => 'mht',
        'MP3 media file'                                 => 'mp3',
        'MP4 media file'                                 => 'mp4',
        'MS Compress archive data'                       => '??',
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
        'Symbolic link to'                               => '',
        'Symbolic link (textual representation)'         => '',
        'POSIX tar archive'                              => 'tar',
        'Targa image data'                               => 'tga',
        'TIFF image data'                                => 'tiff',
        'BitTorrent file'                                => 'torrent',
        'TrueType Font data'                             => 'ttf',
        'Generic text document'                          => 'txt',
        'Unknown binary data'                            => '',
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

    /**
     * @param array $validTypes
     */
    public function __construct(array $validTypes)
    {
        $this->validTypes = $validTypes;
    }

    /**
     * @param $attribute
     * @param $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if ( !$value instanceof UploadedFile ) {
            return false;
        }

        $fileExtension = $this->getFileExtension($value->getPathname());

        return in_array($fileExtension, $this->validTypes);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    private function getFileExtension(string $path): ?string
    {
        $magikaPath = $this->getMagikaPath();
        $result     = $this->executeMagikaCommand($magikaPath, $path);
        $fileLabel  = $this->parseFileLabel($result);

        return $this->getExtensionFromLabel($fileLabel);
    }

    private function getMagikaPath(): string
    {
        $magikaPath = config('magika.magika_binary_path');

        if ( !is_executable($magikaPath) ) {
            throw new RuntimeException("The Magika binary is not executable or not found.");
        }

        return $magikaPath;
    }

    private function executeMagikaCommand(string $magikaPath, string $path): string
    {
        $command = escapeshellcmd("{$magikaPath} ".escapeshellarg($path));
        $result  = shell_exec($command);

        if ( $result === null ) {
            throw new RuntimeException("Failed to execute Magika command.");
        }

        return $result;
    }

    /**
     * @param $output
     *
     * @return string|null
     */
    private function parseFileLabel($output): ?string
    {
        if ( preg_match('/:\s*(.*?)\s*\(confidence:/i', $output, $matches) ) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * @param $fileTypeLabel
     *
     * @return string|null
     */
    private function getExtensionFromLabel($fileTypeLabel): ?string
    {
        return $fileTypeLabel ? ($this->typeMapping[$fileTypeLabel] ?? null) : null;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $formattedTypes = implode(', ', $this->validTypes);

        return __('validation.mimes', [
            'attribute' => $this->attribute,
            'values'    => $formattedTypes
        ]);
    }
}
