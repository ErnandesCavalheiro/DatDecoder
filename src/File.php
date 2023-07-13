<?php

class File
{
    private $pathIn = __DIR__ . '/../data/in';
    private $pathOut = __DIR__ . '/../data/out';
    private $tmp_name;
    private $name;

    public function __construct($tmp_name, $name)
    {
        $this->tmp_name = $tmp_name;
        $this->name = $name;
    }

    public function store()
    {
        if (is_uploaded_file($this->tmp_name)) {
            $destinationPath = $this->pathIn . '/' . $this->name;

            if (move_uploaded_file($this->tmp_name, $destinationPath)) {
                return true;
            }
        }

        return false;
    }

    public function createAndWriteDatFile($filename, $lines) {
        $content = implode("\n", $lines);
        $filepath = $this->pathOut.'/'.$filename . ".dat";
    
        if (file_put_contents($filepath, $content) !== false) {
            echo "Arquivo $filepath criado e escrito com sucesso.";
        } else {
            echo "Erro ao criar ou escrever o arquivo $filepath.";
            exit;
        }
    }
    
}
