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

    public function getIndex()
    {

        return View::make('reservationRequest/ReservationRequest');
    }

    public function getCreate($assetId = null)
    {
        // Prepare Asset Maintenance Type List
        $reservationRequest = [
                '' => 'Select an Reservation Request type',
            ] + AssetMaintenance::getImprovementOptions();
        // Mark the selected asset, if it came in
        $selectedAsset = $assetId;

        $assets = Helper::detailedAssetList();

        $supplier_list = Helper::suppliersList();

        // Render the view
        return View::make('asset_maintenances/edit')
            ->with('asset_list', $assets)
            ->with('selectedAsset', $selectedAsset)
            ->with('supplier_list', $supplier_list)
            ->with('assetMaintenanceType', $assetMaintenanceType)
            ->with('assetMaintenance', new AssetMaintenance);
    }

    /**
     *  Validates and stores the new asset maintenance
     *
     * @see AssetMaintenancesController::getCreate() method for the form
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     * @since [v1.8]
     * @return mixed
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new model instance
        $assetMaintenance = new AssetMaintenance();


        if (e(Input::get('supplier_id')) == '') {
            $assetMaintenance->supplier_id = null;
        } else {
            $assetMaintenance->supplier_id = e(Input::get('supplier_id'));
        }

        if (e(Input::get('is_warranty')) == '') {
            $assetMaintenance->is_warranty = 0;
        } else {
            $assetMaintenance->is_warranty = e(Input::get('is_warranty'));
        }

        if (e(Input::get('cost')) == '') {
            $assetMaintenance->cost = '';
        } else {
            $assetMaintenance->cost =  Helper::ParseFloat(e(Input::get('cost')));
        }

        if (e(Input::get('notes')) == '') {
            $assetMaintenance->notes = null;
        } else {
            $assetMaintenance->notes = e(Input::get('notes'));
        }

        $asset = Asset::find(e(Input::get('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = e(Input::get('asset_id'));
        $assetMaintenance->asset_maintenance_type = e(Input::get('asset_maintenance_type'));
        $assetMaintenance->title                  = e(Input::get('title'));
        $assetMaintenance->start_date             = e(Input::get('start_date'));
        $assetMaintenance->completion_date        = e(Input::get('completion_date'));
        $assetMaintenance->user_id                = Auth::user()->id;

        if (( $assetMaintenance->completion_date == "" )
            || ( $assetMaintenance->completion_date == "0000-00-00" )
        ) {
            $assetMaintenance->completion_date = null;
        }

        if (( $assetMaintenance->completion_date !== "" )
            && ( $assetMaintenance->completion_date !== "0000-00-00" )
            && ( $assetMaintenance->start_date !== "" )
            && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

        // Was the asset maintenance created?
        if ($assetMaintenance->save()) {

            // Redirect to the new asset maintenance page
            return redirect()->to("admin/asset_maintenances")
                ->with('success', trans('admin/asset_maintenances/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($assetMaintenance->getErrors());




    }

    /**
     *  Returns a form view to edit a selected asset maintenance.
     *
     * @see AssetMaintenancesController::postEdit() method that stores the data
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v1.8]
     * @return mixed
     */
    public function getEdit($assetMaintenanceId = null)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the improvement management page
            return redirect()->to('admin/asset_maintenances')
                ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        if ($assetMaintenance->completion_date == '0000-00-00') {
            $assetMaintenance->completion_date = null;
        }

        if ($assetMaintenance->start_date == '0000-00-00') {
            $assetMaintenance->start_date = null;
        }

        if ($assetMaintenance->cost == '0.00') {
            $assetMaintenance->cost = null;
        }

        // Prepare Improvement Type List
        $assetMaintenanceType = [
                '' => 'Select an improvement type',
            ] + AssetMaintenance::getImprovementOptions();

        $assets = Company::scopeCompanyables(Asset::with('model','assignedUser')->get(), 'assets.company_id')->lists('detailed_name', 'id');
        // Get Supplier List
        $supplier_list = Helper::suppliersList();

        // Render the view
        return View::make('asset_maintenances/edit')
            ->with('asset_list', $assets)
            ->with('selectedAsset', null)
            ->with('supplier_list', $supplier_list)
            ->with('assetMaintenanceType', $assetMaintenanceType)
            ->with('assetMaintenance', $assetMaintenance);

    }

    /**
     *  Validates and stores an update to an asset maintenance
     *
     * @see AssetMaintenancesController::postEdit() method that stores the data
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v1.8]
     * @return mixed
     */
    public function postEdit($assetMaintenanceId = null)
    {

        // get the POST data
        $new = Input::all();

        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }



        if (e(Input::get('supplier_id')) == '') {
            $assetMaintenance->supplier_id = null;
        } else {
            $assetMaintenance->supplier_id = e(Input::get('supplier_id'));
        }

        if (e(Input::get('is_warranty')) == '') {
            $assetMaintenance->is_warranty = 0;
        } else {
            $assetMaintenance->is_warranty = e(Input::get('is_warranty'));
        }

        if (e(Input::get('cost')) == '') {
            $assetMaintenance->cost = '';
        } else {
            $assetMaintenance->cost =  Helper::ParseFloat(e(Input::get('cost')));
        }

        if (e(Input::get('notes')) == '') {
            $assetMaintenance->notes = null;
        } else {
            $assetMaintenance->notes = e(Input::get('notes'));
        }

        $asset = Asset::find(e(Input::get('asset_id')));

        if (!Company::isCurrentUserHasAccess($asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Save the asset maintenance data
        $assetMaintenance->asset_id               = e(Input::get('asset_id'));
        $assetMaintenance->asset_maintenance_type = e(Input::get('asset_maintenance_type'));
        $assetMaintenance->title                  = e(Input::get('title'));
        $assetMaintenance->start_date             = e(Input::get('start_date'));
        $assetMaintenance->completion_date        = e(Input::get('completion_date'));

        if (( $assetMaintenance->completion_date == "" )
            || ( $assetMaintenance->completion_date == "0000-00-00" )
        ) {
            $assetMaintenance->completion_date = null;
            if (( $assetMaintenance->asset_maintenance_time !== 0 )
                || ( !is_null($assetMaintenance->asset_maintenance_time) )
            ) {
                $assetMaintenance->asset_maintenance_time = null;
            }
        }

        if (( $assetMaintenance->completion_date !== "" )
            && ( $assetMaintenance->completion_date !== "0000-00-00" )
            && ( $assetMaintenance->start_date !== "" )
            && ( $assetMaintenance->start_date !== "0000-00-00" )
        ) {
            $startDate                                = Carbon::parse($assetMaintenance->start_date);
            $completionDate                           = Carbon::parse($assetMaintenance->completion_date);
            $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays($startDate);
        }

        // Was the asset maintenance created?
        if ($assetMaintenance->save()) {

            // Redirect to the new asset maintenance page
            return redirect()->to("admin/asset_maintenances")
                ->with('success', trans('admin/asset_maintenances/message.create.success'));
        }
        return redirect()->back() ->withInput()->withErrors($assetMaintenance->getErrors());


    }

    /**
     *  Delete an asset maintenance
     *
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v1.8]
     * @return mixed
     */
    public function getDelete($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        // Delete the asset maintenance
        $assetMaintenance->delete();

        // Redirect to the asset_maintenance management page
        return redirect()->to('admin/asset_maintenances')
            ->with('success', trans('admin/asset_maintenances/message.delete.success'));
    }

    /**
     *  View an asset maintenance
     *
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @param int $assetMaintenanceId
     * @version v1.0
     * @since [v1.8]
     * @return View
     */
    public function getView($assetMaintenanceId)
    {
        // Check if the asset maintenance exists
        if (is_null($assetMaintenance = AssetMaintenance::find($assetMaintenanceId))) {
            // Redirect to the asset maintenance management page
            return redirect()->to('admin/asset_maintenances')
                ->with('error', trans('admin/asset_maintenances/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($assetMaintenance->asset)) {
            return static::getInsufficientPermissionsRedirect();
        }

        return View::make('asset_maintenances/view')->with('assetMaintenance', $assetMaintenance);
    }
}