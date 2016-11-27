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

    public function getIndex()
    {

        return View::make('reservationRequest/ReservationRequest');
    }

    public function getCreate($userId=NULL,$assetId = null)
    {
        $selectedassetId = $assetId;
        $selecteduserId=$userId;
        $assets = Helper::detailedAssetList();

        return View::make('asset_maintenances/edit')
            ->with('asset_list', $assets)
            ->with('assetId', $selectedassetId)
            ->with('user_id', $selecteduserId)
            ->with('ReservationRequest', new ReservationRequest);
    }

    public function postCreate()
    {

        $new = Input::all();

       $reservationRequest = new ReseervationRequest();


        $reservationRequest = ReservationRequest::find(e(Input::get('id')));

        $reservationRequest->id               = e(Input::get('id'));
        $reservationRequest->user_id = e(Input::get('user_id'));
        $reservationRequest->asset_id                  = e(Input::get('asset_id'));
        $reservationRequest->start_date             = e(Input::get('start_date'));
        $reservationRequest->end_date        = e(Input::get('end_date'));

        if (( $reservationRequest->end_date == "" )
            || ( $reservationRequest->end_date == "0000-00-00" )
        ) {
            $reservationRequest->end_date = null;
        }

        if (( $reservationRequest->end_date !== "" )
            && ( $reservationRequest->end_date !== "0000-00-00" )
            && ( $reservationRequest->start_date !== "" )
            && ( $reservationRequest->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($reservationRequest->start_date);
            $endDate                           = Carbon::parse($reservationRequest->end_date);
            $reservationRequest->reservation_request_time = $endDate->diffInDays($startDate);
        }

        if ($reservationRequest->save()) {

            return redirect()->to("reservation_request")
                ->with('success', trans('reservation_request/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($reservationRequest->getErrors());




    }


    public function getEdit($assetId = null)
    {
        if (is_null($reservationRequest = reservationRequest::find($assetId))) {
             return redirect()->to('reservation_request')
                ->with('error', trans('reservation_request/message.not_found'));
        }

        if ($reservationRequest->end_date == '0000-00-00') {
            $reservationRequest->end_date = null;
        }

        if ($reservationRequest->start_date == '0000-00-00') {
            $reservationRequest->start_date = null;
        }

        return View::make('reservation_request/edit')
            ->with('asset_list', $assetId)
            ->with('selectedReservationRequest', null)
            ->with('reservationRequest', $reservationRequest);

    }


    public function postEdit($assetId = null)
    {

        $new = Input::all();

        if (is_null($reservationRequest = reservationRequest::find($assetId))) {
             return redirect()->to('reservation_request')
                ->with('error', trans('reservation_request/message.not_found'));
        }

        $asset = Asset::find(e(Input::get('asset_id')));


       $reservationRequest->id               = e(Input::get('id'));
        $reservationRequest->asset_is= e(Input::get('asset_id'));
        $reservationRequest->user_id                  = e(Input::get('user_id'));
        $reservationRequest->start_date             = e(Input::get('start_date'));
        $reservationRequest->end_date        = e(Input::get('end_date'));

        if (( $reservationRequest->end_date == "" )
            || ( $reservationRequest->end_date == "0000-00-00" )
        ) {
            $reservationRequest->end_date = null;
            if (( $reservationRequest->asset_maintenance_time !== 0 )
                || ( !is_null($reservationRequest->reservation_request_time) )
            ) {
                $reservationRequest->reservation_request_time = null;
            }
        }

        if (( $reservationRequest->end_date !== "" )
            && ( $reservationRequest->end_date !== "0000-00-00" )
            && ( $reservationRequest->start_date !== "" )
            && ( $reservationRequest->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($reservation_request->start_date);
            $endDate                           = Carbon::parse($reservation_request->end_date);
            $reservationRequest->reservation_request_time = $endDate->diffInDays($startDate);
        }

        if ($reservationRequest->save()) {

            // Redirect to the new asset maintenance page
            return redirect()->to("reservation_request")
                ->with('success', trans('reservation_request/message.create.success'));
        }
        return redirect()->back() ->withInput()->withErrors($reservationRequest->getErrors());


    }

    public function getDelete($assetId)
    {
        if (is_null($reservationRequest = reservationRequest::find($assetId))) {
            return redirect()->to('reservation_request')
                ->with('error', trans('reservation_request/message.not_found'));
        }

        $reservationRequest->delete();

        return redirect()->to('reservation_request')
            ->with('success', trans('reservation_request/message.delete.success'));
    }
    public function getView($assetId)
    {
        if (is_null($reservationRequest = reservationRequest::find($assetId))) {
            return redirect()->to('admin/asset_maintenances')
                ->with('error', trans('admin/asset_maintenances/message.not_found'));
        }

        return View::make('reservation_request/view')->with('reservationRequest', $reservationRequest);
    }
}