<!DOCTYPE HTML>
<html>
<head>
<!-- START @META SECTION -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{$assetUrl}}images/shortcut icon.png" rel="shortcut icon">
<!-- START @FONT STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:700,400" rel="stylesheet">
    <!--/ END FONT STYLES -->
<!-- START @GLOBAL MANDATORY STYLES -->
    <link href="{{$assetUrl}}global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <!--/ END GLOBAL MANDATORY STYLES -->

<!-- START @THEME STYLES -->
    <link href="{{$assetUrl}}admin/css/custom.css" rel="stylesheet">
    <link href="{{$assetUrl}}admin/css/print-custom.css" rel="stylesheet">
</head>
<body class="page-session page-sound page-header-fixed page-sidebar-fixed">
<div id="print-review-wrapper">
    <div class="double-border">
        <h5 class="text-center">USULAN {{strtoupper($review_propose->propose()->first()->period()->first()->scheme)}}</h5>
    </div>
    <table class="print-header">
        <tbody>
        <tr>
            <td class="print-col-1">Nama Ketua Tim Pengusul</td>
            <td class="print-col-2">:</td>
            <td class="print-col-3">{{$lead->full_name}}</td>
        </tr>
        <tr>
            <td class="print-col-1">Judul</td>
            <td class="print-col-2">:</td>
            <td class="print-col-3">{{$review_propose->propose()->first()->title}}</td>
        </tr>
        </tbody>
    </table>
    <table class="print-table">
        <thead>
            <tr>
                <th class="print-col-1">Aspek yang dinilai</th>
                <th class="print-col-2">Skor</th>
                <th class="print-col-3">Bobot (%)</th>
                <th class="print-col-4">Nilai Bobot</th>
                <th class="print-col-5">Komentar Penilai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sum_score = 0;
                $sum_quality = 0;
                $sum_total_score = 0;
            @endphp
            @foreach($review_proposes_i as $item)
                <tr>
                    <td class="print-col-1">{{$item->aspect}}</td>
                    <td class="print-col-2 text-center">{{$item->score}}</td>
                    <td class="print-col-3 text-center">{{$item->quality}}</td>
                    <td class="print-col-4 text-center">{{$item->score * $item->quality}}</td>
                    <td class="print-col-5">{{$item->comment}}</td>
                </tr>
                @php
                    $sum_score += $item->score;
                    $sum_quality += $item->quality;
                    $sum_total_score += ($item->score * $item->quality);
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="print-col-1 text-center">Total</td>
                <td class="print-col-2 text-center">{{$sum_score}}</td>
                <td class="print-col-3 text-center">{{$sum_quality}}</td>
                <td class="print-col-4 text-center">{{$sum_total_score}}</td>
                <td class="print-col-5"></td>
            </tr>
        </tfoot>
    </table>

    <div class="print-footer">
        <div class="row">
            <div class="col-xs-6">Rekomendasi Jumlah Dana: Rp.{{number_format($review_propose->recommended_amount)}}</div>
        </div>
        <div class="row">
            <div class="col-xs-6"><u>Kesimpulan: {{$review_propose->conclusion()->first()->conclusion_desc}}</u></div>
            <div class="col-xs-6">Medan, {{$today_date}}</div>

            &nbsp;
            <div class="clearfix"></div>

            <div class="col-xs-6"></div>
            <div class="col-xs-6">Penilai</div>

            <div class="col-xs-6">Saran:</div>
            <div class="col-xs-6">Nama: {{$reviewer->full_name}}</div>

            <div class="col-xs-6">{{$review_propose->suggestion}}</div>
            <div class="col-xs-6">Tanda Tangan:</div>
        </div>
    </div>
</div>
<script>
    window.print();
</script>
</body>
</html>