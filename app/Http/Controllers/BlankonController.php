<?php

namespace App\Http\Controllers;

use App\DownloadLog;
use App\Member;
use App\ModelSDM\Lecturer;
use App\ModelSDM\Employee;
use App\Propose;
use Carbon\Carbon;
use Monolog\Handler\IFTTTHandler;
use View;
use Illuminate\Support\Facades\Auth;

class BlankonController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Blankon Controller
      |--------------------------------------------------------------------------
      |
     */

    // url for asset outside folder laravel
    public $assetUrl;
    // global css
    public $css = [];
    // global js
    public $js = [];
    // body class	
    public $bodyClass = "page-session page-sound page-header-fixed page-sidebar-fixed";
    // sidebar left class	
    public $sidebarClass = "sidebar-circle";

    public $mainTitle = 'LPM USU - Pengabdian Masyarakat';

    public $v_auths = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->setApp();

        $this->middleware(function ($request, $next)
        {
            if (Auth::user())
            {
                $user_info = $this->getEmployee(Auth::user()->nidn);
                View::share(compact('user_info'));

                $i = 0;
                $notifications = [];
                $members = Member::where('nidn', Auth::user()->nidn)->where('status', 'waiting')->get();
                foreach ($members as $member)
                {
                    $propose = $member->propose()->first();
//                    if ($propose->period()->where('years', '>=', intval(Carbon::now()->toDateString()))->exists())
//                    {
                    $notifications[$i]['propose_id'] = $propose->id;
                    $notifications[$i]['propose_title'] = $propose->title;
                    $i++;
//                    }
                }
                View::share(compact('notifications'));
            }

            return $next($request);
        });
    }

    /**
     * initialize blankon
     */
    public function setApp()
    {

        $this->assetUrl = config('constant.assetUrl');

        // set global mandatory css
        $this->css = [
            'globals' => ['global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css']
        ];

        // theme styles
        $this->css['themes'] = [
            'admin/css/reset.css',
            'admin/css/layout.css',
            'admin/css/components.css',
            'admin/css/plugins.css',
            'admin/css/themes/laravel.theme.css' => ['id' => ''],
            'admin/css/themes/red.theme.css' => ['id' => 'theme'],
            'admin/css/custom.css',
        ];

        $this->css['pages'] = [];

        $this->js = [
            'cores' => $this->getCoresJs(),
            'ies'   => $this->getIesJs()
        ];

        $this->js['plugins'] = [];

        $this->js['scripts'] = [
            'admin/js/apps.js',
            'admin/js/pages/blankon.dashboard.js',
            'admin/js/demo.js'
        ];

//        dd(Auth::user()->nidn);
//        if(Auth::user()){
//            $user_info = Lecturer::where('employee_card_serial_number', Auth::user()->nidn)->first();
//        }


        // pass variable to view
        View::share('assetUrl', $this->assetUrl);
        View::share('bodyClass', $this->bodyClass);
        View::share('sidebarClass', $this->sidebarClass);
    }

    public function getEmployee($nidn)
    {
        $ret = Employee::where('number_of_employee_holding', $nidn)->first();
        if ($ret === null)
        {
            $ret = Lecturer::where('employee_card_serial_number', $nidn)->first();
            if ($ret === null)
            {
                $ret = new Lecturer();
                $ret->full_name = "Super User";
                $ret->employee_card_serial_number = 'SuperUser';
                $ret->number_of_employee_holding = 'SuperUser';
            }
        }

        if($ret->photo === null || $ret->photo === "")
        {
            $ret->photo = 'photo.jpg';
        }
        $ret->photo = 'http://simsdm.usu.ac.id/photos/' . $ret->photo;

        return $ret;
    }

    /**
     * get js core scripts
     * @return array blankon's core javascript plugins
     */
    private function getCoresJs()
    {
        return [
            'global/plugins/bower_components/jquery/dist/jquery.min.js',
            'global/plugins/bower_components/jquery-cookie/jquery.cookie.js',
            'global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js',
            'global/plugins/bower_components/typehead.js/dist/handlebars.js',
            'global/plugins/bower_components/typehead.js/dist/typeahead.bundle.min.js',
            'global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js',
            'global/plugins/bower_components/jquery.sparkline.min/index.js',
            'global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js',
            'global/plugins/bower_components/ionsound/js/ion.sound.min.js',
            'global/plugins/bower_components/bootbox/bootbox.js'
        ];
    }

    /**
     * get Internet Explorer plugin
     * @return array javascript plugins for IE
     */
    private function getIesJs()
    {
        return [
            'global/plugins/bower_components/html5shiv/dist/html5shiv.min.js',
            'global/plugins/bower_components/respond-minmax/dest/respond.min.js'
        ];
    }

    public function setEmail($status_code, Propose $propose, $nidn = null)
    {
        switch ($status_code)
        {
            case 'VA' :
                $members = $propose->member()->get();
                foreach ($members as $key => $member)
                {
                    if ($member->external !== '1')
                    {
                        $recipients[$key] = $member->lecturer()->first()->email;
                    }
                }
                $email = [];
                $email['subject'] = '[SIMABDIMAS] Verifikasi Anggota';
                $email['recipient_name'] = 'Bapak/Ibu';
                $email['body_content'] = 'Kami informasikan bahwa anda telah didaftarkan pada usulan pengabdian Universitas Sumatera Utara. Untuk itu, kami meminta Bapak/Ibu untuk melakukan verifikasi atas usulan tersebut. Untuk melakukan verifikasi, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/proposes/' . $propose->id . '/verification">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'accepted':
                $lecturer = $this->getEmployee($propose->created_by);
                $member = $this->getEmployee(Auth::user()->nidn);

                $status_translate = 'menyetujui';

                $recipients = $lecturer->email;
                $email = [];
                $email['subject'] = '[SIMABDIMAS] Verifikasi Anggota';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa anggota anda yakni : "' . $member->full_name . '" telah ' . $status_translate . ' permohonan verifikasi anggota untuk pengabdian anda. Untuk informasi lebih lanjut, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/proposes/' . $propose->id . '/edit">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'rejected':
                $lecturer = $this->getEmployee($propose->created_by);
                $member = $this->getEmployee(Auth::user()->nidn);

                $status_translate = 'menolak';

                $recipients = $lecturer->email;
                $email = [];
                $email['subject'] = '[SIMABDIMAS] Verifikasi Anggota';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa anggota anda yakni : "' . $member->full_name . '" telah ' . $status_translate . ' permohonan verifikasi anggota untuk pengabdian anda. Untuk informasi lebih lanjut, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/proposes/' . $propose->id . '/edit">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'UU' :
                $lecturer = $this->getEmployee($propose->created_by);

                $recipients = $lecturer->email;
                $email['subject'] = '[SIMABDIMAS] Unggah Usulan';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa usulan pengabdian anda sudah selesai verifikasi anggota. Untuk itu, kami meminta Bapak/Ibu untuk melakukan unggah usulan atas usulan tersebut. Untuk melakukan unggah usulan, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/proposes/' . $propose->id . '/edit">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'PR':
                $recipients = [
                    '0' => 'suryawijaya@usu.ac.id',
//                    '1' => 'lp@usu.ac.id'
                ];
                $email['subject'] = '[SIMABDIMAS] Penentuan Reviewer';
                $email['recipient_name'] = 'Operator Sistem Pengabdian';
                $email['body_content'] = 'Diinformasikan bahwa terdapat usulan untuk dilakukan penentuan reviewer. Untuk itu, kami meminta Bapak/Ibu untuk melakukan penentuan reviewer atas usulan tersebut. Untuk melakukan penentuan reviewer, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/reviewers/assign/' . $propose->id . '">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'reviewer new':
                $reviewer = $this->getEmployee($nidn);
                $recipients = $reviewer->email;
                $email['subject'] = '[SIMABDIMAS] Penentuan Reviewer';
                $email['recipient_name'] = $reviewer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa terdapat usulan yang telah di-assign kepada Bapak/Ibu sebagai reviewer. Untuk itu, kami meminta Bapak/Ibu untuk melakukan review atas usulan tersebut. Untuk melakukan review, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/review-proposes/' . $propose->id . '/review">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'reviewer delete':
                $reviewer = $this->getEmployee($nidn);
                $recipients = $reviewer->email;
                $email['subject'] = '[SIMABDIMAS] Penentuan Reviewer';
                $email['recipient_name'] = $reviewer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa terdapat usulan yang telah di-unassign dari Bapak/Ibu sebagai reviewer.';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'PU':
                $lecturer = $this->getEmployee($propose->created_by);

                $recipients = $lecturer->email;
                $email['subject'] = '[SIMABDIMAS] Perbaikan Usulan';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa usulan pengabdian anda diterima dan memerlukan perbaikan. Untuk itu, kami meminta Bapak/Ibu untuk melakukan perbaikan usulan tersebut. Untuk melakukan perbaikan usulan, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/proposes/' . $propose->id . '/revision">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'UD':
                $research = $propose->research()->first();
                $lecturer = $this->getEmployee($propose->created_by);

                $recipients = $lecturer->email;
                $email['subject'] = '[SIMABDIMAS] Usulan Diterima';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa usulan pengabdian anda telah diterima. Untuk itu, kami meminta Bapak/Ibu untuk melanjutkan pengabdian tersebut dan melaporkan laporan kemajuan dan laporan akhir. Untuk mengunggah laporan, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/researches/' . $research->id . '/edit">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'UT':
                $lecturer = $this->getEmployee($propose->created_by);

                $recipients = $lecturer->email;
                $email['subject'] = '[SIMABDIMAS] Usulan Ditolak';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa usulan pengabdian anda telah ditolak.';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'VL':
                $recipients = [
                    '0' => 'suryawijaya@usu.ac.id',
//                    '1' => 'lp@usu.ac.id'
                ];
                $research = $propose->research()->first();

                $email['subject'] = '[SIMABDIMAS] Validasi Luaran';
                $email['recipient_name'] = 'Operator Sistem Pengabdian';
                $email['body_content'] = 'Diinformasikan bahwa terdapat luaran yang perlu divalidasi. Untuk itu, kami meminta Bapak/Ibu untuk melakukan validasi luaran tersebut. Untuk melakukan validasi luaran, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/researches/' . $research->id . '/approve">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'RL':
                $research = $propose->research()->first();
                $lecturer = $this->getEmployee($propose->created_by);

                $recipients = $lecturer->email;
                $email['subject'] = '[SIMABDIMAS] Revisi Luaran';
                $email['recipient_name'] = $lecturer->full_name;
                $email['body_content'] = 'Kami informasikan bahwa luaran pengabdian perlu direvisi. Untuk itu, kami meminta Bapak/Ibu untuk melakukan revisi luaran tersebut. Untuk revisi luaran, Bapak/Ibu diminta untuk login pada link ini: <a href="https://simpel.usu.ac.id/researches/' . $research->id . '/output">Sistem Pengabdian USU</a>';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
            case 'PS':
                $lecturer = $this->getEmployee($propose->created_by);
                $members = $propose->member()->get();
                foreach ($members as $key => $member)
                {
                    if ($member->external !== '1')
                    {
                        $recipients[$key] = $member->lecturer()->first()->email;
                    }
                }
                array_push($recipients, $lecturer->email);

                $email['subject'] = '[SIMABDIMAS] Pengabdian Selesai';
                $email['recipient_name'] = 'Bapak/Ibu';
                $email['body_content'] = 'Kami informasikan bahwa pengabdian anda telah selesai.';
                $email['body_detail_content'] = 'Demikian informasi ini kami sampaikan.<br/>Dikirim otomatis oleh Sistem Penlitian USU';

                dispatch(new SendNotificationEmail($recipients, $email, $propose));
                break;
        }
    }

    public function storeDownloadLog($propose_id, $download_type, $file_name_ori, $file_name, $created_by)
    {
        DownloadLog::create([
            'propose_id' => $propose_id,
            'download_type' => $download_type,
            'file_name_ori' => $file_name_ori,
            'file_name' => $file_name,
            'created_by' => $created_by,
        ]);
    }

}
