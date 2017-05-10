<?php
namespace App\Helper;

use App\Utility\TErrorCode;
use App\Utility\JSONObject;
use App\Utility\TStringUtility;

class TAppHelper extends THelper
{
    //for user information
    public function getUserJson(JSONObject $json)
    {
        return $this->getJson($json, ['userInfo']);
    }
    public function getEmail(JSONObject $json)
    {
        return $this->getValue($json, ['userName', 'email']);
    }
    public function getPassword(JSONObject $json)
    {
        return $this->getValue($json, ['pin', 'password']);
    }
    public function getUserId(JSONObject $json)
    {
        return $this->getValue($json, ['userId', 'id']);
    }
    public function getUserName(JSONObject $json)
    {
        return $this->getValue($json, ['display', 'name']);
    }
    
    //for console information
    public function getConsoleJson(JSONObject $json)
    {
        return $this->getJson($json, ['deviceInfo', 'console']);
    }
    public function getSerialNo(JSONObject $json)
    {
        return $this->getValue($json, ['serialNo', 'serial_no', 'DeviceInfo_serialNo', 'SN']);
    }
    public function getAddress(JSONObject $json)
    {
        return $this->getValue($json, ['mac']);
    }
    public function getModel(JSONObject $json)
    {
        return $this->getValue($json, ['model']);
    }
    
    //for compliance master
    public function getComplianceMasterJson(JSONObject $json)
    {
        return $this->getJson($json, ['compliancemaster', 'master']);
    }
    public function getStartTime(JSONObject $json)
    {
        return $this->getValue($json, ['startTime', 'StartTime', 'start', 'STime', 'startDate']);
    }
    public function getEndTime(JSONObject $json)
    {
        return $this->getValue($json, ['endTime', 'end', 'ETime', 'endDate']);
    }
    public function getTreatment(JSONObject $json)
    {
        return $this->getValue($json, ['Dr_TR', 'treatment']);
    }
    public function getLeakage(JSONObject $json)
    {
        return $this->getValue($json, ['Dr_LK', 'leakage']);
    }
    public function getTimeZone(JSONObject $json)
    {
        return $this->getValue($json, ['Time_Zone', 'timeZone']);
    }
    public function getVersion(JSONObject $json)
    {
        return $this->getValue($json, ['version']);
    }
    public function getLatitude(JSONObject $json)
    {
        return $this->getValue($json, ['latitude']);
    }
    public function getLongitude(JSONObject $json)
    {
        return $this->getValue($json, ['longitude']);
    }
    public function getConsoleStart(JSONObject $json)
    {
        return $this->getValue($json, ['console_start']);
    }

    //for questionnaire
    public function getQuestionnaireJson(JSONObject $json)
    {
        return $this->getJson($json, ['questionnaire']);
    }
    public function getEvening1(JSONObject $json)
    {
        return $this->getValue($json, ['beforeQ1', 'evening1'], TErrorCode::NOT_FOUND);
    }
    public function getEvening2(JSONObject $json)
    {
        return $this->getValue($json, ['beforeQ2', 'evening2'], TErrorCode::NOT_FOUND);
    }
    public function getEveningTime(JSONObject $json)
    {
        return $this->getValue($json, ['before', 'evening_time']);
    }
    public function getMorning1(JSONObject $json)
    {
        return $this->getValue($json, ['afterQ1', 'morning1'], TErrorCode::NOT_FOUND);
    }
    public function getMorning2(JSONObject $json)
    {
        return $this->getValue($json, ['afterQ2', 'morning2'], TErrorCode::NOT_FOUND);
    }
    public function getMorningTime(JSONObject $json)
    {
        return $this->getValue($json, ['after', 'morning_time']);
    }
    public function getIsRefill(JSONObject $json)
    {
        return $this->getValue($json, ['reApply'], false);
    }
    
    //for records
    public function getRecordsJson(JSONObject $json)
    {
        //return $this->getJson($json, ['record']);
        return $this->getJsonArray($json, ['record']);
    }
    
    //for assignTime
    public function getAssignTime(JSONObject $json)
    {
        return $this->getValue($json, ['assignTime']);
    }
    
    //for upload 
    public function getUploadFileName(JSONObject $json)
    {
        return $this->getValue($json, ['uploadFile']);
    }
    public function getFileOwner(JSONObject $json)
    {
        return $this->getValue($json, ['Owner']);
    }
    public function getCarryFile(JSONObject $json)
    {
        return TStringUtility::toBoolean($this->getValue($json, ['carryFile']));
    }
    
    //for role
    public function getJsonRole(JSONObject $json)
    {
        return $this->getJson($json, ['roleInfo']);
    }
    
    //for organization
    public function getJsonOrganization(JSONObject $json)
    {
        return $this->getJson($json, ['orgInfo']);
    }
    
    public function getAsOrganization(JSONObject $json)
    {
        return $this->getValue($json, ['asOrganization']);
    }
    
    public function getName(JSONObject $json)
    {
        return $this->getValue($json, ['name']);
    }
}
