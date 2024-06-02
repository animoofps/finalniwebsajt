<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['studij']) && isset($_POST['broj-rata']) && isset($_POST['popust'])) {
        $studij = $_POST['studij'];
        $broj_rata = (int)$_POST['broj-rata'];
        $popust = $_POST['popust'];

        $iznos_rate = izracunaj_iznos_rate($studij, $broj_rata);

        if ($popust == 'bez popusta') {
            $popust_iznos = 0;
        } else {
            switch ($popust) {
                case 'Matura':
                    $popust_iznos = 0.1;
                    break;
                case 'Vrhunski sportaš':
                    $popust_iznos = 0.2;
                    break;
                case 'Državno natjecanje':
                    $popust_iznos = 0.3;
                    break;
                default:
                    $popust_iznos = 0;
            }
        }

        $konacna_cijena = $iznos_rate - ($iznos_rate * $popust_iznos);
        $konacna_cijena = number_format($konacna_cijena, 2);

        $rate_label = ($broj_rata == 1) ? 'ratu' : (($broj_rata >= 2 && $broj_rata <= 4) ? 'rate' : 'rata');
        $studij_label = ucfirst(preg_replace('/a$/', 'e', $studij));
        if ($popust == 'bez popusta')
            echo "<p>Iznos rate za studij $studij_label na $broj_rata $rate_label $popust : $konacna_cijena EUR</p>";
        else
            echo "<p>Iznos rate za studij $studij_label na $broj_rata $rate_label s $popust popustom: $konacna_cijena EUR</p>";
    } else {
        echo "<p>Greška: Nedostaju potrebni podaci za izračun.</p>";
    }
}

function izracunaj_iznos_rate($studij, $broj_rata)
{
    $cijene_studija = array(
        "Matematika" => 1500,
        "Fizika" => 1800,
        "Geografija" => 1250,
        "Geologija" => 1350,
        "Biologija" => 1300,
        "Informatika" => 1600,
        "Geofizika" => 1100
    );
    if (array_key_exists($studij, $cijene_studija)) {
        $cijena_studija = $cijene_studija[$studij];
        $iznos_rate = $cijena_studija / $broj_rata;

        return $iznos_rate;
    } else {
        return "Nepoznat studij";
    }
}
