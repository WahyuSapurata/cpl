<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMahasiswa = [
            ['nim' => '60900118029', 'name' => 'MUHAMMAD FAUZAN'],
            ['nim' => '60900117033', 'name' => 'AHMAD DHITYA PRISMAWAN SYAMSURI'],
            ['nim' => '60900119020', 'name' => 'ZULFIKAR J'],
            ['nim' => '60900119035', 'name' => 'AKHMAD ZUHDY HAFID'],
            ['nim' => '60900119037', 'name' => 'MUHAMMAD RAFLI SYAHBAN'],
            ['nim' => '60900122074', 'name' => 'MUH. RUSLI'],
            ['nim' => '60900122002', 'name' => 'CAHYANA RAMADANI. S'],
            ['nim' => '60900122003', 'name' => 'NUR ISMI AULIA'],
            ['nim' => '60900122006', 'name' => 'MIFTAHUL JANNAH'],
            ['nim' => '60900122008', 'name' => 'SALSABILA AZIS'],
            ['nim' => '60900122009', 'name' => 'TIARA REZKY PUTRI CAHYANI'],
            ['nim' => '60900122021', 'name' => 'ISRAYANI'],
            ['nim' => '60900122022', 'name' => 'ANDI MARITZA SYAHRANI IBRAHIM'],
            ['nim' => '60900122023', 'name' => 'NURUL ILMI'],
            ['nim' => '60900122024', 'name' => 'AHMAD SYAHIR'],
            ['nim' => '60900122025', 'name' => 'MUHAMMAD ALIF ALQADRI'],
            ['nim' => '60900122026', 'name' => 'MUHAMMAD ROFIQ ROIHAN'],
            ['nim' => '60900122027', 'name' => 'MUH. AFDAL NAS'],
            ['nim' => '60900122028', 'name' => 'MAGFIRAH SUHAMA'],
            ['nim' => '60900122029', 'name' => 'MURSAL RAFAEL ABDIH LASALEH'],
            ['nim' => '60900122030', 'name' => 'FATHIER MUHAMMAD ARIESTA'],
            ['nim' => '60900122032', 'name' => 'ABDUL WAHID'],
            ['nim' => '60900122033', 'name' => 'MOHAMMAD DJAFAR RAMADHAN'],
            ['nim' => '60900121016', 'name' => 'ARIS MUNANDAR'],
            ['nim' => '60900122034', 'name' => 'AHSANI AMALIA'],
            ['nim' => '60900122036', 'name' => 'HUSNUN FADHILAH'],
            ['nim' => '60900122037', 'name' => 'ALDY JANUARI'],
            ['nim' => '60900122038', 'name' => 'ADITYA RAHMATULLAH'],
            ['nim' => '60900122039', 'name' => 'MUHAMMAD IMRAN'],
            ['nim' => '60900122040', 'name' => 'RISMAWANA'],
            ['nim' => '60900122042', 'name' => 'PUTRIANI'],
            ['nim' => '60900122043', 'name' => 'ADAM HERIL'],
            ['nim' => '60900122044', 'name' => 'ST. AISYAH YUSUF'],
            ['nim' => '60900122045', 'name' => 'M. FAHRUL ARYA WARDANA'],
            ['nim' => '60900122046', 'name' => 'ARYA NASUTION HERMAN'],
            ['nim' => '60900122049', 'name' => 'AHMAD FARHAN'],
            ['nim' => '60900122050', 'name' => 'AFIA NAILUFAR'],
            ['nim' => '60900122051', 'name' => 'NIAR RAMADANI'],
            ['nim' => '60900122053', 'name' => 'RAHMAT AL AYYUBY'],
            ['nim' => '60900122056', 'name' => 'MUH. TAUFIK RACHMAT'],
            ['nim' => '60900122057', 'name' => 'ANDI ISRATUL AULIA. AM'],
            ['nim' => '60900122058', 'name' => 'AMANAH'],
            ['nim' => '60900122059', 'name' => 'NURPANADA'],
            ['nim' => '60900122060', 'name' => 'AHMAD RAENALDY'],
            ['nim' => '60900122061', 'name' => 'CITRA PUTRI AMALIA'],
            ['nim' => '60900122062', 'name' => 'ARSY NURUL AQNI'],
            ['nim' => '60900122065', 'name' => 'NURUL HIKMA'],
            ['nim' => '60900122068', 'name' => 'HELMY AHMED'],
            ['nim' => '60900122069', 'name' => 'NURUL FITRA'],
            ['nim' => '60900122070', 'name' => 'MUHAMMAD AFIF AUFAR ABSHAR'],
            ['nim' => '60900122073', 'name' => 'INDRA NURMAN'],
            ['nim' => '60900122075', 'name' => 'MUH. RUHUL RANTISI AKSI'],
            ['nim' => '60900122076', 'name' => 'WARDATUL ADAWIAH'],
            ['nim' => '60900123023', 'name' => 'AGUNG SETYADI'],
            ['nim' => '60900123024', 'name' => 'MUHAMMAD HISYAM YASSAR AKBAR'],
            ['nim' => '60900123025', 'name' => 'AIDIL FITRA'],
            ['nim' => '60900120034', 'name' => 'ALIYAH'],
            ['nim' => '60900117008', 'name' => 'ANDAR SADOPI'],
            ['nim' => '60900117032', 'name' => 'M. RESQI WAHYUDI'],
            ['nim' => '60900117058', 'name' => 'MUH. ALIF AKBAR'],
            ['nim' => '60900118020', 'name' => 'ANAS MUBARAK YASIN MASUD'],
            ['nim' => '60900118024', 'name' => 'NUR FADILLA UTAMI'],
            ['nim' => '60900118028', 'name' => 'AZIZAH AWAL FITRAH'],
            ['nim' => '60900119033', 'name' => 'EKA WAHYUNI DARMAYANTI'],
            ['nim' => '60900119034', 'name' => 'SULFIANTI SYAMSUL'],
            ['nim' => '60900119042', 'name' => 'MUQADDIMAH'],
            ['nim' => '60900119047', 'name' => 'INDA RATNA SALIM'],
            ['nim' => '60900120003', 'name' => 'MERI ANDANI'],
            ['nim' => '60900120042', 'name' => 'SYAHRUL'],
            ['nim' => '60900123001', 'name' => 'AGUNG PRASASTI ABADI'],
            ['nim' => '60900123002', 'name' => 'ATIKA RESKI'],
            ['nim' => '60900123003', 'name' => 'RATNA ARTIKA SARI'],
            ['nim' => '60900123004', 'name' => 'AHMAD FAIZ'],
            ['nim' => '60900123005', 'name' => 'MUH. ANGGI RIFQIYADI'],
            ['nim' => '60900123006', 'name' => 'RISNA FEBRIANTI'],
            ['nim' => '60900123007', 'name' => 'RAHMAT NUR'],
            ['nim' => '60900123008', 'name' => 'MURSALIM'],
            ['nim' => '60900123009', 'name' => 'HIKMA RAMADHANI'],
            ['nim' => '60900123010', 'name' => 'ANDI JALIL SAPUTRA'],
            ['nim' => '60900123011', 'name' => 'SELFIRA'],
            ['nim' => '60900123012', 'name' => 'MUHAMMAD ALFAUZAN BOBIHU'],
            ['nim' => '60900123013', 'name' => 'AKHWAN NUR ASMI'],
            ['nim' => '60900123014', 'name' => 'JUSMAWATI'],
            ['nim' => '60900123015', 'name' => 'MUH. RAYHAN TRI JAYADI'],
            ['nim' => '60900123016', 'name' => 'NUR ANNISA'],
            ['nim' => '60900123017', 'name' => 'NABILA ZALSABILA HAFNUL'],
            ['nim' => '60900123018', 'name' => 'ANDI TIARA PATETEI'],
            ['nim' => '60900123019', 'name' => 'FAJRUL HIDAYAT AMINI'],
            ['nim' => '60900123020', 'name' => 'MUHAMMAD AKRAM AT TAQI'],
            ['nim' => '60900123021', 'name' => 'GAFUR RAHIM'],
            ['nim' => '60900123022', 'name' => 'ANDI MUHAMMAD SAID ABDILLAH ADIL'],
            ['nim' => '60900123026', 'name' => 'NURUL HALISA Z'],
            ['nim' => '60900123027', 'name' => 'HUSNUL MUTMAINNAH'],
            ['nim' => '60900123028', 'name' => 'ANDI MUHAMMAD ASADUL HAYYAN NASRULLAH'],
            ['nim' => '60900123029', 'name' => 'AHMAD MUSAWWIR'],
            ['nim' => '60900123030', 'name' => 'ZHAKA HIDAYAT YASIR'],
            ['nim' => '60900123031', 'name' => 'HARAHMAN ABD ARIB'],
            ['nim' => '60900123032', 'name' => 'RISKY DAMAYANTI'],
            ['nim' => '60900123033', 'name' => 'ERIK ASTAMAN'],
            ['nim' => '60900123034', 'name' => 'MUH. SYAIFUL HAQ ARAFAH'],
            ['nim' => '60900123035', 'name' => 'ARDITA ZALZABILAH'],
            ['nim' => '60900123036', 'name' => 'AUDYA PUTRI ATHA ILLAH'],
            ['nim' => '60900123037', 'name' => 'NUR FAIZAH AZ ZAHRAH'],
            ['nim' => '60900123038', 'name' => 'ALWAN DWI PERMANA'],
            ['nim' => '60900123039', 'name' => 'ANASTASIA INDRIANI ASBANU'],
            ['nim' => '60900123040', 'name' => 'MUHAMMAD KHALIKIL RASAK'],
            ['nim' => '60900123041', 'name' => 'MIFTAHUL REZKY'],
            ['nim' => '60900123042', 'name' => 'MUH MAHIR IMAM B'],
            ['nim' => '60900123043', 'name' => 'PUTRI NANDITA'],
            ['nim' => '60900123044', 'name' => 'HUSNUL KHOTIMAH SAIDA'],
            ['nim' => '60900123045', 'name' => 'SYAMSUARDI'],
            ['nim' => '60900123046', 'name' => 'MUTHIA NUR FAIQA'],
            ['nim' => '60900123047', 'name' => 'ANDI FIKRAN MAULANA'],
            ['nim' => '60900123048', 'name' => 'NAJWA DEWI LARASATI'],
            ['nim' => '60900123049', 'name' => 'MUH. AQHIEL AKBAR PRATAMA SYAM'],
            ['nim' => '60900123050', 'name' => 'SITI AISYAH'],
            ['nim' => '60900118033', 'name' => 'AHMAD ILHAM'],
            ['nim' => '60900118040', 'name' => 'AJMIANTI'],
            ['nim' => '60900118041', 'name' => 'RIKY SATRIA'],
            ['nim' => '60900118042', 'name' => 'TRI RAHAYU PANTIPURNAWATI'],
            ['nim' => '60900118050', 'name' => 'DEVI LESTARI'],
            ['nim' => '60900118051', 'name' => 'HADIARNI'],
            ['nim' => '60900118052', 'name' => 'NUR ISMI'],
            ['nim' => '60900118054', 'name' => 'NURANTI.S'],
            ['nim' => '60900118055', 'name' => 'MAGFIRA'],
            ['nim' => '60900119002', 'name' => 'NURUL FAHIRA R'],
            ['nim' => '60900119003', 'name' => 'ADE PRATIWI'],
            ['nim' => '60900119005', 'name' => 'NURFADILAH HARIS'],
            ['nim' => '60900119006', 'name' => 'SITTI NUR AZIZAH DJUNAEDY'],
            ['nim' => '60900119008', 'name' => 'ANDI NURUL INAYA'],
            ['nim' => '60900119009', 'name' => 'NUR RIFDAH'],
            ['nim' => '60900119010', 'name' => 'FATHUL JANNAH'],
            ['nim' => '60900119011', 'name' => 'NURWINDA SARI'],
            ['nim' => '60900119012', 'name' => 'FEBI RAMDANI'],
            ['nim' => '60900119013', 'name' => 'ANA PEBRIANA'],
            ['nim' => '60900119014', 'name' => 'NURWAFIQA RAMLI'],
            ['nim' => '60900119016', 'name' => 'ANDI ENGKU PUTRIBUANA'],
            ['nim' => '60900119018', 'name' => 'ANSAR'],
            ['nim' => '60900119022', 'name' => 'NISWA AYU LESTARI'],
            ['nim' => '60900119023', 'name' => 'SHINTA CRYSDIANA DEWI'],
            ['nim' => '60900119024', 'name' => 'ASFIRA MUHRI'],
            ['nim' => '60900117009', 'name' => 'ACHMAD RIZALDI SAAD'],
            ['nim' => '60900117011', 'name' => 'LUKMAN'],
            ['nim' => '60900117013', 'name' => 'ABDULLAH AL BAITSU TENRIPADA'],
            ['nim' => '60900117020', 'name' => 'RIS CAKRA SANJAYA'],
            ['nim' => '60900117027', 'name' => 'DEWI FITRAH NATSIR'],
            ['nim' => '60900117042', 'name' => 'ALWI N'],
            ['nim' => '60900117044', 'name' => 'ASWAR SALAM'],
            ['nim' => '60900117046', 'name' => 'ARDY SALZABILLAH'],
            ['nim' => '60900117054', 'name' => 'NUR ISLAMI FITRA'],
            ['nim' => '60900117063', 'name' => 'ANDI IVAN RAMADHAN'],
            ['nim' => '60900117071', 'name' => 'SYAMSIAH'],
            ['nim' => '60900117072', 'name' => 'IBNU AKRAM'],
            ['nim' => '60900118002', 'name' => 'FITRAH'],
            ['nim' => '60900118004', 'name' => 'RINDI ANTIKA'],
            ['nim' => '60900118006', 'name' => 'HARFINA FEBRIANTI HAFID'],
            ['nim' => '60900118011', 'name' => 'NURFADILLA SUHERMAN'],
            ['nim' => '60900118012', 'name' => 'MAULIDANI MAHMUD'],
            ['nim' => '60900118017', 'name' => 'LISA ANRIANI'],
            ['nim' => '60900118023', 'name' => 'SITI NURMIANTI'],
            ['nim' => '60900118025', 'name' => 'TITHANIA INDAH PERMATA HATI'],
            ['nim' => '60900118026', 'name' => 'ANDI BAU AMMAR'],
            ['nim' => '60900118027', 'name' => 'ANDI TENRI AWARU'],
            ['nim' => '60900118032', 'name' => 'ANDI NURUL FADHILAH'],
            ['nim' => '60900118034', 'name' => 'RESKI WAHDANIAH'],
            ['nim' => '60900118035', 'name' => 'MAYANG SARI'],
            ['nim' => '60900118037', 'name' => 'WAHYUHIDAYAT'],
            ['nim' => '60900118038', 'name' => 'PUTRI SUCI RAMDANI'],
            ['nim' => '60900118039', 'name' => 'ILHAM PRABUJAYA'],
            ['nim' => '60900119025', 'name' => 'MENTARI ANUGRAH AMELIA J'],
            ['nim' => '60900119036', 'name' => 'NUR ISLAMIA TULJANNA'],
            ['nim' => '60900119040', 'name' => 'A.FITRIA RAMADHANI'],
            ['nim' => '60900119046', 'name' => 'RAMLAH SARI'],
            ['nim' => '60900119049', 'name' => 'ANDI RISYDAH MUAYYADAH'],
            ['nim' => '60900119050', 'name' => 'BAU RESKI AMALIA'],
            ['nim' => '60900119051', 'name' => 'DIAN RESKI AMANDA'],
            ['nim' => '60900120001', 'name' => 'FARID AIDIL FITRAH'],
            ['nim' => '60900120002', 'name' => 'AWI MAULANA'],
            ['nim' => '60900120006', 'name' => 'DINA'],
            ['nim' => '60900120008', 'name' => 'ANNISA SOFYAN'],
            ['nim' => '60900120009', 'name' => 'M. RIZKI MADYA'],
            ['nim' => '60900120013', 'name' => 'ZAINUL FAKHRI'],
            ['nim' => '60900120016', 'name' => 'MUIZ MUHARRAM'],
            ['nim' => '60900120020', 'name' => 'M. FAJRATUL IKHSAN'],
            ['nim' => '60900120023', 'name' => 'ASWAR FAJAR'],
            ['nim' => '60900120024', 'name' => 'SERLIANA'],
            ['nim' => '60900120027', 'name' => 'RAHMADANI RAMLI'],
            ['nim' => '60900120030', 'name' => 'ANASTASYA PRAMESTI CAHYANI'],
            ['nim' => '60900120031', 'name' => 'MIFTAHUL FAUZI'],
            ['nim' => '60900120043', 'name' => 'IRMA SURIANI S'],
            ['nim' => '60900120044', 'name' => 'MUHAMMAD REYHAN AMAL'],
            ['nim' => '60900118043', 'name' => 'REZA ARDIANSYAH'],
            ['nim' => '60900119007', 'name' => 'WAHYUNI DWI SAPUTRI'],
            ['nim' => '60900119015', 'name' => 'SRI WAHYUNI'],
            ['nim' => '60900119019', 'name' => 'ULFA RAHMAN'],
            ['nim' => '60900119028', 'name' => 'MUHAMMAD AZRIAL MAHESHA'],
            ['nim' => '60900119031', 'name' => 'MUAWYAH'],
            ['nim' => '60900119041', 'name' => 'ANDY RESKIDARSYAH'],
            ['nim' => '60900119048', 'name' => 'ARYA RASENDRIYA BARATA'],
            ['nim' => '60900120010', 'name' => 'AGUNG ADI PRASETYO'],
            ['nim' => '60900120017', 'name' => 'AMEL KRISANDARESTA'],
            ['nim' => '60900120021', 'name' => 'JUSNI'],
            ['nim' => '60900120022', 'name' => 'NABILAH FAQITA MASYORA'],
            ['nim' => '60900120028', 'name' => 'NADIAH ADAWIYAH FAHMI'],
            ['nim' => '60900120033', 'name' => 'NURFADILAH'],
            ['nim' => '60900120035', 'name' => 'MUHAMMAD FIKRI'],
            ['nim' => '60900120036', 'name' => 'AWWIR WAHYUDDIN'],
            ['nim' => '60900120039', 'name' => 'SUMIYATI'],
            ['nim' => '60900120040', 'name' => 'NUURAN AFIILA NURSYAM'],
            ['nim' => '60900120045', 'name' => 'IKMAL'],
            ['nim' => '60900120025', 'name' => 'NUR FARID MUFID NR'],
            ['nim' => '60900120037', 'name' => 'MUTIARA ANDINI'],
            ['nim' => '60900120032', 'name' => 'FITRIANI'],
            ['nim' => '60900122005', 'name' => 'SITI MARYAM H.'],
            ['nim' => '60900122010', 'name' => 'AFIFAH'],
            ['nim' => '60900122011', 'name' => 'RAHMA AMALIA'],
            ['nim' => '60900122012', 'name' => 'ADILLA NURUL INSANIYA'],
            ['nim' => '60900122014', 'name' => 'REZKI AWALIAH'],
            ['nim' => '60900122016', 'name' => 'PUTRI KENCANA AYU'],
            ['nim' => '60900122017', 'name' => 'MUHAMMAD GILANG'],
            ['nim' => '60900122018', 'name' => 'FILA MIFTAHUL KHAIRAT'],
            ['nim' => '60900122019', 'name' => 'WULANDARI'],
            ['nim' => '60900122020', 'name' => 'PUTRI APRIANI BURANTANI'],
            ['nim' => '60900122031', 'name' => 'MUHAMMAD FADHIL BAHARTRI'],
            ['nim' => '60900122035', 'name' => 'RYAN FAIDIL KURNIAWAN'],
            ['nim' => '60900122041', 'name' => 'MUH. DWICKY P. SANJAYA'],
            ['nim' => '60900122047', 'name' => 'ARY AFFANDY IDHAM'],
            ['nim' => '60900122054', 'name' => 'AHMAD FAUZAN'],
            ['nim' => '60900122055', 'name' => 'MUHAMMAD FARID IRSYADILLAH'],
            ['nim' => '60900122063', 'name' => 'DHIEVA ESA SHAHIELLA'],
            ['nim' => '60900122071', 'name' => 'NURMALA'],
            ['nim' => '60900119030', 'name' => 'AKBAR ANDIPA'],
            ['nim' => '60900118045', 'name' => 'YUSRIL'],
            ['nim' => '60900121019', 'name' => 'M. AFDAL'],
            ['nim' => '60900123051', 'name' => 'ANDI AMALIAH MUTHMAINNAH YUNUS'],
            ['nim' => '60900123052', 'name' => 'ADLAN KHALID'],
            ['nim' => '60900123053', 'name' => 'NUR AISYAH'],
            ['nim' => '60900123054', 'name' => 'NUR AULIYAH ISTIQOMAH'],
            ['nim' => '60900123055', 'name' => 'CAHAYA MASITA'],
            ['nim' => '60900123056', 'name' => 'MUH. RAIHAN ALAMSYAH'],
            ['nim' => '60900123057', 'name' => 'SAYYID RAFSANJANI ALMAHDALI'],
            ['nim' => '60900123058', 'name' => 'RESKI AULIYA'],
            ['nim' => '60900123059', 'name' => 'ANDI AHMAD ZULFA KAHFI'],
            ['nim' => '60900123060', 'name' => 'ELSA NATASYA'],
            ['nim' => '60900123061', 'name' => 'FAUZI AMRIANI'],
            ['nim' => '60900123062', 'name' => 'AFDAL SUHERMAN'],
            ['nim' => '60900123063', 'name' => 'NUR INDRIANI'],
            ['nim' => '60900123064', 'name' => 'IMAM MUBARAK. A'],
            ['nim' => '60900123065', 'name' => 'RYAN ANDIKA'],
            ['nim' => '60900123066', 'name' => 'RASNAH'],
            ['nim' => '60900123067', 'name' => 'NABILAH NUUR AQIILAH'],
            ['nim' => '60900123068', 'name' => 'AHMAD MUSLIH'],
            ['nim' => '60900123069', 'name' => 'MUHAMMAD YUSWANE AULIA'],
            ['nim' => '60900123070', 'name' => 'ABDUL JALIL ARLIANSYAH'],
            ['nim' => '60900123071', 'name' => 'ARYA KAISRA PUTRA'],
            ['nim' => '60900123072', 'name' => 'HABIL NASRUDDIN'],
            ['nim' => '60900123073', 'name' => 'NURFADILLAH MENINA PALAN'],
            ['nim' => '60900123074', 'name' => 'ZUL FARIS ALI'],
            ['nim' => '60900120019', 'name' => 'MUHAMMAD ALIEF DAFFA'],
            ['nim' => '60900120029', 'name' => 'ADAM'],
            ['nim' => '60900121029', 'name' => 'MUH. NUR FAJAR'],
            ['nim' => '60900118053', 'name' => 'FAHRIANA'],
            ['nim' => '60900119029', 'name' => 'KEVIN BIMANTARA'],
            ['nim' => '60900119045', 'name' => 'NURKHUMAIRAH FADYA MALIK'],
            ['nim' => '60900120038', 'name' => 'HAYAR USMAN'],
            ['nim' => '60900121077', 'name' => 'IRMAYANI'],
            ['nim' => '60900121079', 'name' => 'ILHAM RAMADHAN'],
            ['nim' => '60900121080', 'name' => 'APRISAL'],
            ['nim' => '60900118022', 'name' => 'ABDUL QABIR ANUGRAH RAMADHANA'],
            ['nim' => '60900118046', 'name' => 'ANDI ANISA'],
            ['nim' => '60900120011', 'name' => 'AWAL PRASETYA JAYADI'],
            ['nim' => '60900120012', 'name' => 'MUH. FADLI FATURRAHMAN'],
            ['nim' => '60900120041', 'name' => 'MUHAMMAD NUR AQIL SHODIQ AB'],
            ['nim' => '60900121001', 'name' => 'NADYA FEBRIANTI'],
            ['nim' => '60900121002', 'name' => 'MAHARANI SANIA BUDIARTI'],
            ['nim' => '60900121003', 'name' => 'ANNISA EKA JAYANTI SANTOSO'],
            ['nim' => '60900121004', 'name' => 'FAISAL FAIZ'],
            ['nim' => '60900121005', 'name' => 'ANANDA INTAN PRATIWI'],
            ['nim' => '60900121006', 'name' => 'RISAL'],
            ['nim' => '60900121007', 'name' => 'RAHMAWATI'],
            ['nim' => '60900121008', 'name' => 'NIMATUL FAJRI'],
            ['nim' => '60900121009', 'name' => 'YUNITA'],
            ['nim' => '60900121010', 'name' => 'MUH. ABDIAWAN PRATAMA'],
            ['nim' => '60900121012', 'name' => 'RIANGDANA JURMASARI'],
            ['nim' => '60900121013', 'name' => 'SITI AISYAH'],
            ['nim' => '60900121014', 'name' => 'MURNI'],
            ['nim' => '60900121017', 'name' => 'RAIZSA ZAHRA AINAYYA AHMADI'],
            ['nim' => '60900121018', 'name' => 'YUNITA AMALIA'],
            ['nim' => '60900121042', 'name' => 'MUHAMMAD AIMAN'],
            ['nim' => '60900121044', 'name' => 'FATURRACHMAN YUNUS'],
            ['nim' => '60900121056', 'name' => 'MUH RIDHA ILAHI'],
            ['nim' => '60900121068', 'name' => 'MUH. AHRI ROMIZAH ARFIAN'],
            ['nim' => '60900121069', 'name' => 'MUH. IRFAN'],
            ['nim' => '60900121020', 'name' => 'RYAN HIDAYAT'],
            ['nim' => '60900121022', 'name' => 'MUAMMAR'],
            ['nim' => '60900121026', 'name' => 'DIA AULIANI'],
            ['nim' => '60900121027', 'name' => 'ANDI NURUL AIN NASMIN'],
            ['nim' => '60900121028', 'name' => 'MUHAMMAD ZUHAIR HAMZAH'],
            ['nim' => '60900121030', 'name' => 'ASRUL HIDAYAT'],
            ['nim' => '60900121032', 'name' => 'NUR AISYAH WULANDARI'],
            ['nim' => '60900121033', 'name' => 'ADAM ABDUL MAJID FACHRUDIN'],
            ['nim' => '60900121034', 'name' => 'M. FAJRIN'],
            ['nim' => '60900121036', 'name' => 'ISMA FAUZIAH'],
            ['nim' => '60900121037', 'name' => 'NURUL AYNI'],
            ['nim' => '60900121038', 'name' => 'ANANDA FATLIAH HAMZAH'],
            ['nim' => '60900121040', 'name' => 'SYAHRUL RUSDHA'],
            ['nim' => '60900121045', 'name' => 'M.VADEL AMRI TAUFIK'],
            ['nim' => '60900121046', 'name' => 'SAPARUDDIN'],
            ['nim' => '60900121047', 'name' => 'MUHAMMAD NURHIDAYAT'],
            ['nim' => '60900121048', 'name' => 'DIAN'],
            ['nim' => '60900121049', 'name' => 'DIAN FITRIA AFSARI'],
            ['nim' => '60900121050', 'name' => 'MUH. ARSY MAWARDI. MZ'],
            ['nim' => '60900121052', 'name' => 'DIKCY SUKKRYSNO'],
            ['nim' => '60900121053', 'name' => 'NURUL FADHILA NUR'],
            ['nim' => '60900121054', 'name' => 'AQILAH NURUL FAUZIAH'],
            ['nim' => '60900121057', 'name' => 'MUFLIH RAMADHAN'],
            ['nim' => '60900121059', 'name' => 'A.HILDA SAFUTRI'],
            ['nim' => '60900121060', 'name' => 'NURHALIS'],
            ['nim' => '60900121061', 'name' => 'MAWADDAH NASIFAH ALDA SAKTI'],
            ['nim' => '60900121062', 'name' => 'FIRMAN RESKI RAMADHAN'],
            ['nim' => '60900121064', 'name' => 'AHMAD GHAZALI'],
            ['nim' => '60900121065', 'name' => 'NURUL FANISA'],
            ['nim' => '60900121066', 'name' => 'ALYAH ANANDA MASRI'],
            ['nim' => '60900121070', 'name' => 'NURSYAMSU RIJAL USMAN'],
            ['nim' => '60900121071', 'name' => 'YUSRIL MAHENDRA'],
            ['nim' => '60900121072', 'name' => 'MUH KAHLIL KAWIWARA FAIZAL'],
            ['nim' => '60900121074', 'name' => 'AHMAD ALFATH'],
            ['nim' => '60900121075', 'name' => 'MUH.ASKAR'],
            ['nim' => '60900121076', 'name' => 'HENDRAWAN H. HERY'],
            ['nim' => '60900117043', 'name' => 'RIHAN NUGRAHA'],
            ['nim' => '60900122048', 'name' => 'MUAMMAR AL FIQRAM'],
        ];

        foreach ($dataMahasiswa as $data) {
            Mahasiswa::create([
                'uuid' => Uuid::uuid4()->toString(),
                'nim' => $data['nim'],
                'nama' => $data['name'],
            ]);
        }
    }
}
