<?php
class Kampus
{
    private $kampus;

    public function __construct($kampus)
    {
        $this->kampus = $kampus;
    }

    public function getKampus()
    {
        return $this->kampus;
    }

    public function setKampus($kampus)
    {
        $this->kampus = $kampus;
    }
}

interface DosenWaliDAO
{
    public function urusKrs();
    public function konsultasi(Mahasiswa $mahasiswa);
}

class Dosenwali extends Kampus implements DosenWaliDAO
{
    private $nama;

    public function __construct($nama, $kampus)
    {
        $this->nama = $nama;
        parent::__construct($kampus);
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function urusKrs()
    {
        return "Dosen " . $this->getNama() . " sedang mengurus KRS";
    }

    public function konsultasi(Mahasiswa $mahasiswa)
    {
        return "Dosen Wali " . $this->getNama() . " sedang konsultasi dengan Mahasiswa " . $mahasiswa->getNama();
    }
}

class Matkul
{
    private $matkul = array();

    public function __construct($kode, $nama, $sks)
    {
        $this->matkul[] = array(
            'kode' => $kode,
            'nama' => $nama,
            'sks' => $sks
        );
    }

    public function getMatkul()
    {
        return $this->matkul;
    }

    public function setMatkul($kode, $nama, $sks)
    {
        $this->matkul[] = array(
            'kode' => $kode,
            'nama' => $nama,
            'sks' => $sks
        );
    }

    public function printMatkul()
    {
        foreach ($this->matkul as $m) {
            echo "Kode : " . $m['kode'] . "<br>" . "Nama : " . $m['nama'] . "<br>" . "SKS : " . $m['sks'] . "<br>";
        }
    }
}

class Mahasiswa extends Kampus
{
    private $nim, $nama;

    public function __construct($nim, $nama, $kampus)
    {
        $this->nim = $nim;
        $this->nama = $nama;
        parent::__construct($kampus);
    }

    public function getNim()
    {
        return $this->nim;
    }

    public function setNim($nim)
    {
        $this->nim = $nim;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function konsultasi(Dosenwali $dosenwali)
    {
        return "Mahasiswa " . $this->getNama() . " sedang konsultasi dengan Dosen Wali " . $dosenwali->getNama();
    }

    // public function __toString()
    // {
    //     return "NIM : " . $this->nim . "<br>" . "Nama : " . $this->nama . "<br>" . "Prodi : " . $this->prodi . "<br>" . "Jurusan : " . $this->jurusan . "<br>" . "Kampus : " . $this->getKampus();
    // }
}

class KRS
{
    private $mahasiswa, $matkul;

    public function __construct(Mahasiswa $mahasiswa, Matkul $matkul)
    {
        $this->mahasiswa = $mahasiswa;
        $this->matkul = $matkul;
    }

    public function getMahasiswa()
    {
        return $this->mahasiswa;
    }

    public function setMahasiswa($mahasiswa)
    {
        $this->mahasiswa = $mahasiswa;
    }

    public function getMatkul()
    {
        return $this->matkul;
    }

    public function setMatkul($matkul)
    {
        $this->matkul = $matkul;
    }

    public function addMatkul(Matkul $matkul)
    {
        $this->matkul[] = $matkul;
    }

    public function removeMatkul(Matkul $matkul)
    {
        $key = array_search($matkul, $this->matkul);
        unset($this->matkul[$key]);
    }

    public function __toString()
    {
        return "Mahasiswa : " . $this->mahasiswa . "<br>" . "Mata Kuliah : " . $this->matkul;
    }
}

$matkul = new Matkul("M001", "Dasar Pemrograman", 3);
$matkul->setMatkul("P002", "Basis Data", 4);
$matkul->setMatkul("C003", "Matematika", 3);
$matkul->setMatkul("B004", "Pemrograman Mobile", 3);
$matkul->setMatkul("E005", "Sistem Operasi", 2);

$nim = isset($_POST['nim']) ? $_POST['nim'] : "";
$mhs = isset($_POST['nama_mhs']) ? $_POST['nama_mhs'] : "";
$dosen = isset($_POST['dosen']) ? $_POST['dosen'] : "";
$kmp = isset($_POST['kampus']) ? $_POST['kampus'] : "";

$kampus = new Kampus($kmp);
$mahasiswa = new Mahasiswa($nim, $mhs, $kampus->getKampus());
$dosenwali = new Dosenwali($dosen, $kampus->getKampus());
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row ">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Form Mahasiswa</h3>
                        </div>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim">
                            </div>
                            <div class="mb-3">
                                <label for="nama_mhs" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama_mhs" name="nama_mhs">
                            </div>
                            <div class="mb-3">
                                <label for="dosen" class="form-label">Nama Dosen Wali</label>
                                <input type="text" class="form-control" id="dosen" name="dosen">
                            </div>
                            <div class="mb-3">
                                <label for="kampus" class="form-label">Kampus</label>
                                <input type="text" class="form-control" id="kampus" name="kampus">
                            </div>
                            <?php foreach ($matkul->getMatkul() as $m) : ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="matkul[]" id="matkul" value="<?= $m['kode']; ?>">
                                    <label class="form-check-label" for="matkul"><?= $m['nama']; ?></label>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <?php if (isset($_POST['nim'])) : ?>
                    <div class="card d-flex justify-content-center align-items-center">
                        <ul class="list-inline">
                            <li>NIM : <?= $mahasiswa->getNim(); ?></li>
                            <li>Nama : <?= $mahasiswa->getNama(); ?></li>
                            <li>Kampus : <?= $kampus->getKampus(); ?></li>
                            <li><?= $dosenwali->urusKrs(); ?></li>
                            <li><?= $mahasiswa->konsultasi($dosenwali); ?></li>
                            <li>Matkul Terpilih:</li>
                            <?php if (isset($_POST['matkul']) && is_array($_POST['matkul'])) : ?>
                                <?php 
                                $totalSks = 0;
                                foreach ($matkul->getMatkul() as $m) : 
                                    if (in_array($m['kode'], $_POST['matkul'])) :
                                        $totalSks += $m['sks'];
                                ?>
                                        <li><?= $m['nama']; ?></li>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                                <li>Total SKS: <?= $totalSks; ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>