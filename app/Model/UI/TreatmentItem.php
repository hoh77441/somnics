<?php
namespace App\Model\UI;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use App\Model\User;
use App\Model\ComplianceApp;

use App\Utility\TDateUtility;
use App\Utility\TStringUtility;

class TreatmentItem extends Model
{
    public static function getComplianceApp(User $user, $aggregation=true)
    {
        if( $aggregation )
        {
            return self::aggregationTreatments($user);
        }
        return self::allTreatments($user);
    }
    
    public static function aggregationTreatments(User $user)
    {
        $items = array();
        $archiveDate = Carbon::create(2000, 1, 1, 0, 0, 0);
        $key = '';
        foreach($user->complianceApps as $app)
        {
            $dateTime = TDateUtility::from($app->archiveDate);
            if( $archiveDate->ne($dateTime) )  //different archive date
            {
                $key = TStringUtility::trimTimeFidld($app->archiveDate);
                $archiveDate = $dateTime;
                
                $items[$key] = $app;
                continue;
            }
            
            //update information for the same archive date
            $items[$key]->treatment += $app->treatment;
            $items[$key]->leakage += $app->leakage;
        }
        return $items;
    }
        
    public static function allTreatments(User $user)
    {
        return null;
    }
}
