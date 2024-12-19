<?php
// Data patokan konversi untuk tahun 1446 H hingga 1467 H
include 'tahun.php';

function convertHijriyahToMasehi($bulan, $hari_ke, $year) {
    global $data;
    $date_start = null;
    $days_in_month = 0;

    if (!isset($data[$year])) {
        return "Data untuk tahun $year tidak ditemukan.";
    }

    foreach ($data[$year] as $d) {
        if ($d[0] == $bulan) {
            $date_start = DateTime::createFromFormat('d-M-y', $d[2]);
            $days_in_month = $d[3];
            break;
        }
    }

    if ($date_start === null) {
        return "Bulan tidak ditemukan.";
    }

    $interval = new DateInterval('P' . ($hari_ke - 1) . 'D');
    $date_start->add($interval);

    return $date_start->format('d-M-Y');
}

function getPasaranJawa($start_index, $offset) {
    $pasaran = ["Legi", "Pahing", "Pon", "Wage", "Kliwon"];
    $index = ($start_index + $offset) % 5;
    return $pasaran[$index];
}

function convertToArabicNumbers($number) {
    $arabic_numbers = ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'];
    return strtr($number, $arabic_numbers);
}

function getTooltip($bulan, $day, $year) {
    $tooltip = '';
    if ($bulan == 'Muharram' && $day == 1 && $year == 1446) {
        $tooltip = 'Hari Tahun baru Islam 1446 H = L/B: 40/120, Tinggi hilal/elongasi: 6,85°/8°'; 
    } elseif (($day == 29 OR $day == 30)  && $bulan == 'Muharram') {
        $tooltip = 'New Moon 2024-08-04 18:13:39 WIB';     
    } elseif (($day == 29 OR $day == 30) && $bulan == 'Syakban' && $year == 1446) {
        $tooltip = 'New Moon Riyadh, 025-02-28 21:55:02 WIB. Tinggi hilal: 6.33°, elongasi: 8.11°';
    } elseif (in_array($day, [13, 14, 15])) {
        $tooltip = 'Ayyamul bidh';
    } elseif ($bulan == 'Muharram' && $day == 9) {
        $tooltip = 'Hari Tasua';
    } elseif ($bulan == 'Muharram' && $day == 10) {
        $tooltip = 'Hari Asyuro';
    } elseif ($bulan == 'Safar' && $day == 1 && $year == 1446) {
        $tooltip = 'Awal bulan Safar, Denver (UTC-6,L:39.7392,B:-104.9903), 2024-08-05 02:09:01 UTC, H:5.32°,  E:8.03°'; 
    } elseif ($day == 30  && $bulan == 'Safar' && $year == 1446) {
        $tooltip = 'New Moon 2024-09-03 08:56:12 WIB';   
    } elseif ($bulan == 'Rabiulawal' && $day == 1 && $year == 1446) {
        $tooltip = 'Awal bulan Rabiulawal,  Dakar (UTC,L: 14.6928, B:-17.4467), 2024-09-03 19:19:52 UTC, H:5.66°, E:8.08°';         
    } elseif ($bulan == 'Rabiulawal' && $day == 12) {
        $tooltip = 'Hari Maulid Nabi';
    } elseif ($bulan == 'Rabiulawal' && $day == 30) {
        $tooltip = 'New Moon, 2024-10-03 01:49:54 WIB';  
    } elseif ($bulan == 'Rabiulakhir' && $day == 1 && $year == 1446) {
        $tooltip = 'Awal bulan Rabiulakhir, Mogadishu (UTC+3, L:2.0469, B:45.3182), 2024-10-03 14:50:15 UTC, H:6.05°, E:9.09°';        
    } elseif ($bulan == 'Rabiulakhir' && $day == 29) {
        $tooltip = 'New Moon, 2024-11-01 19:47:48 WIB'; 
        
    } elseif ($bulan == 'Rajab' && $day == 27) {
        $tooltip = 'Hari Isra Mi\'raj';
    } elseif ($bulan == 'Syakban' && $day == 15) {
        $tooltip = 'Hari Nisyfu Syaban';
    } elseif ($bulan == 'Ramadan' && $day == 1) {
        $tooltip = 'Awal Ramadhan';
    } elseif ($bulan == 'Ramadan' && $day == 17) {
        $tooltip = 'Hari Nuzulul Quran';
    } elseif (($day == 29 OR $day == 30) && $bulan == 'Ramadan' && $year == 1446) {
        $tooltip = 'New Moon Riyadh, 025-02-28 21:55:02 WIB. Tinggi hilal: 6.33°, elongasi: 8.11°';        
    } elseif ($bulan == 'Syawal' && $day == 1) {
        $tooltip = 'Hari Idul Fitri';
    } elseif ($bulan == 'Dzulhijjah' && $day == 9) {
        $tooltip = 'Hari Puasa Arafah';
    } elseif ($bulan == 'Dzulhijjah' && $day == 10) {
        $tooltip = 'Hari Idul Adha';
    } elseif ($bulan == 'Dzulhijjah' && in_array($day, [11, 12, 13])) {
        $tooltip = 'Hari Tasyrik';
    }
    return $tooltip;
}

function displayMonth($month_data, $start_pasaran_offset, $year) {
    $month_name = $month_data[0];
    $start_day_name = $month_data[1];
    $start_date = $month_data[2];
    $start_day = DateTime::createFromFormat('d-M-y', $start_date)->format('w');
    $days_in_month = $month_data[3];
    $year_hijriyah = $year;
    $current_date = DateTime::createFromFormat('d-M-y', $start_date);

    echo '<div id="' . strtolower($month_name) . '-container" align="center">';
    echo '<h2 onclick="printMonth(\'' . strtolower($month_name) . '-container\')" title="Klik untuk print!"><span style="font-size: 2.1em; cursor: pointer;">' . $month_name . ' ' . $year_hijriyah . ' H</span></h2>';
    echo '<div class="calendar">'; 

    echo '<table border="1px" cellpadding="5" style="border-collapse: collapse; text-align: center; width: 100%; margin-bottom: 20px;">';
    echo '<thead style="background-color: #f2f2f2;"><tr>';
    //echo '<th colspan="7"><span style="font-size: 2.5em;">' . $month_name . ' ' . $year_hijriyah . ' H </span></th>';
    echo '</tr></thead>';
    echo '<tr style="background-color: lightblue; text-transform: uppercase; font-size: 2em;"><th>Ahad</th><th>Senin</th><th>Selasa</th><th>Rabu</th><th>Kamis</th><th>Jumat</th><th>Sabtu</th></tr>';
    echo '<tr>';

    for ($i = 0; $i < $start_day; $i++) {
        echo '<td></td>';
    }

    $current_date_masehi = date('d-M-Y');

    for ($day = 1; $day <= $days_in_month; $day++) {
        $hijri_date = convertHijriyahToMasehi($month_name, $day, $year);
        $pasaran = getPasaranJawa($start_pasaran_offset, $day - 1);
        $day_of_week = ($day + $start_day - 1) % 7;
        $style = '';
        $tooltip = getTooltip($month_name, $day, $year);

if ($hijri_date == $current_date_masehi) {
    $style = ' title="Tanggal Hari ini" style="background-color: black; color: white;"';
} elseif ($tooltip) {
    $style = ' style="background-color: #EDF08A; color: blue;"';
} elseif ($day_of_week == 0) {
    $style = ' style="background-color: pink;"';
} elseif ($day_of_week == 5) {
    $style = ' style="background-color: lightgreen;"';
}


        $arabic_day = convertToArabicNumbers($day);
        echo '<td' . $style . ' title="' . $tooltip . '"><span style="font-size: 2.5em;">' . $arabic_day . '</span><br><span style="font-size: 1.2em;">' . $hijri_date . '<br>' . $pasaran . '</span></td>';
        
        if (($day + $start_day) % 7 == 0) {
            echo '</tr><tr>';
        }
    }

    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

    return ($start_pasaran_offset + $days_in_month) % 5;
}

if (isset($_POST['year'])) {
    $selected_year = $_POST['year'];
} else {
    $selected_year = 1446;
}

$start_pasaran_offset = 4; // Start offset for the first year
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>KALENDER HIJRIYAH GLOBAL TUNGGAL</title>
    <link rel="shortcut icon" href="https://falakmu.id/khgt/kalender.png">
    <script src="https://falakmu.id/PrayTimes.js"></script>
    <script src="https://falakmu.id/khgt/tanggal.js"></script>
    <link rel="stylesheet" href="https://falakmu.id/khgt/khgtstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body>
    <center>
        <div align="center" style="background-color: #f2f2f2; margin-top: 5px; margin-bottom: 10px; white-space: nowrap;" class="header">   
            <h2 style="margin-top: 20px; padding: 10px;">KALENDER HIJRIYAH GLOBAL TUNGGAL</h2>
            <div style="margin-top: 10px;">
                <a target="_self" href="https://falakmu.id/khgt/hitungan/" title="Akses blog falakiyah">
                    <button class="elegant-button">
                        <i class="fas fa-calculator"></i>&nbsp;Hitungan
                    </button>
                </a>
                <a target="_self" href="https://falakmu.id/khgt/shalat/" title="Akses jadwal shalat bulanan">
                    <button class="elegant-button">
                        <i class="fas fa-praying-hands"></i>&nbsp;Shalat
                    </button>
                </a>        
                <a target="_self" href="https://falakmu.id/kompas/" title="Akses konversdi kalender">
                    <button class="elegant-button">
                        <i class="fas fa-compass"></i>&nbsp;Kompas
                    </button>
                </a> 
                <a target="_self" href="https://falakmu.id/kiblat/index.php" title="Akses input data masjid">
                    <button class="elegant-button">
                        <i class="fas fa-mosque"></i>&nbsp;Masjid
                    </button>
                </a>
        
                <a target="_self" href="https://falakmu.id/rashdulkiblat/" title="Akses data kiblat masjid">
                    <button class="elegant-button">
                        <i class="fas fa-compass"></i>&nbsp;Kiblat
                    </button>
                </a>
        
                <a target="_self" href="https://falakmu.id/khgt/konversi/" title="Akses konversdi kalender">
                    <button class="elegant-button">
                        <i class="fas fa-calendar"></i>&nbsp;Konversi
                    </button>
                </a> 
                <a target="_self" href="https://falakmu.id/khgt/dokumen/" title="Akses konversdi kalender">
                    <button class="elegant-button">
                        <i class="fas fa-book"></i>&nbsp;Ebook
                    </button>
                </a> 
            </div>
            <div border="0" align="center" style="font-size:20px; color: black; margin-top: 10px; background-color: white; width: 100%;">
                            <center>
                                <hr/>
                                <span style="font-size:20px; color: blue; margin-top: 10px;">
                                <script type="text/javascript">tulis_Tanggal(3);</script>
                                </span>
                                <a href="https://time.is/Semarang" id="time_is_link" rel="nofollow"></a>
                                <span style="font-size:20px; color: black;">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                                <span id="Semarang_z41c" style="font-size:20px; color: blue;"></span>
                                <script src="//widget.time.is/t.js" type="text/javascript"></script>
                                <script type="text/javascript">time_is_widget.init({Semarang_z41c:{}});</script>
                                <span style="font-size:20px; color: blue;">&nbsp;&nbsp;WIB</span>
                            </center>
                            <hr/>
            </div>
        </div>
        Countdown: <iframe src="https://falakmu.id/poso/" width="100%" height="60px" frameborder="0">
        </iframe>    
         <hr/>
</center>
        <p style="padding: 10px; margin-bottom: 10px; margin-left: 10px; font-size: 20px;  margin-top: 10px;  white-space: nowrap;" class="center;"><b>CATATAN:</b> <br/>1) Kalender ini disusun berdasarkan KHGT MTT PP Muhammdiyah, <br/>2) Jika header nama bulan diklik, maka akan dicetak menjadi file PDF.</b>
        </p>
        <form method="post" style="display: inline;">
            <label style="font-size: 20px; margin-left: 10px; margin-top: 10px; margin-bottom: 10px; white-space: nowrap;" class="center;" for="year">Pilih Tahun Hijriyah:</label>
            <select class="elegant-button" name="year" id="year" onchange="this.form.submit()">
                <?php
                foreach ($data as $year => $months) {
                    $selected = $year == $selected_year ? 'selected' : '';
                    echo "<option value='$year' $selected>$year H</option>";
                }
                ?>
            </select>
        </form>

    <?php
    // Retrieve previous year last month pasaran offset
    if ($selected_year > 1446) {
        $prev_year = $selected_year - 1;
        $last_month_prev_year = end($data[$prev_year]);
        $start_pasaran_offset = displayMonth($last_month_prev_year, $start_pasaran_offset, $prev_year);
    }

    foreach ($data[$selected_year] as $month) {
        $start_pasaran_offset = displayMonth($month, $start_pasaran_offset, $selected_year);
    }
    ?>
    
    <div align="center" width="100%">
        <p align="center"><b>CATATAN:</b><br/> 1) Analisis/Rasionalisasi Penentuan Awal Bulan Qomariyah berdasarkan kriteria KHGT dapat dibaca/didownload melalui link <a href="https://falakmu.id/khgt/dokumen/Analisis_Penentuan_Awal_Bulan_Qomariyah_Berdasarkan_4_Kriteria_KHGT.pdf" target="_blank">DI SINI</a>. <br/>2) Link Download&nbsp;<a target="_self" href="https://falakmu.id/khgt/dokumen/" title="Akses Ebook Ilmu Falak">EBOOK</a>.
        </p>
        <hr/>
        <a href="https://chatgpt.com/g/g-f9bI5yZpa-chatmugpt" target="_blank"><img src="https://falakmu.id/github/khgt/chatmugpt-logo.png" width="200px"></a>
        <hr/>
        <p><small>Copyleft (ɔ) Kasmui, https://falakmu.id, 2024, All Wrongs Reserved.</small></p>
    </div>
    <script>
        function printMonth(containerId) {
            const container = document.getElementById(containerId);
            const header = container.querySelector('h2').outerHTML;
            const calendar = container.querySelector('.calendar').outerHTML;
            const html = `<div>${header}${calendar}</div>`;
            const opt = {
                margin: [0.01, 0.2, 0.2, 0.1],
                filename: `KHGT-calendar-${containerId}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
            };
            html2pdf().from(html).set(opt).save();
        }
    </script>
</body>
</html>
