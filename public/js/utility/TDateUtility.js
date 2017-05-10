function now()
{
    Date.prototype.yyyymmdd = function() {
        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth()+1).toString();  //month is 0-base
        var dd = this.getDate().toString();
        
        return yyyy + (mm[1] ?mm :"0"+mm[0]) + (dd[1] ?dd :"0"+dd[0]);
    }
    
    var date = new Date();
    return date.yyyymmdd();
}

function toTime(seconds)
{
    var hour, minute, second;
    
    second = (Math.floor(seconds % 60)).toString();
    minute = (Math.floor((seconds / 60) % 60)).toString();
    hour = (Math.floor(seconds / (60 * 60))).toString();
    
    return (hour[1] ?hour :"0"+hour[0]) + ":" + (minute[1] ?minute :"0"+minute[0]) + ":" + (second[1] ?second :"0"+second[0]);
}
