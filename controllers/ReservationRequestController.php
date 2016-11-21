<?php
/**
 * Created by PhpStorm.
 * User: Tom-PC-School
 * Date: 20/11/2016
 * Time: 17:23
 */
namespace App\Http\Controllers;



use App\Helpers\Helper;
use App\Http\Requests\AssetRequest;
use App\Http\Requests\AssetFileRequest;
use App\Http\Requests\AssetCheckinRequest;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Depreciation;
use App\Models\Location;
use App\Models\Manufacturer; //for embedded-create
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Validator;
use Artisan;
use Auth;
use Config;
use League\Csv\Reader;
use DB;
use Image;
use Input;
use Lang;
use Log;
use Mail;
use Paginator;
use Redirect;
use Response;
use Slack;
use Str;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use TCPDF;
use View;
use Carbon\Carbon;
use Gate;


class ReservationRequestController extends Controller
{
    public function getReservationRequest($assetId)
    {
        return View::make('reservationRequest/ReservationRequest')-with('asset_Id',$assetId);
    }
}