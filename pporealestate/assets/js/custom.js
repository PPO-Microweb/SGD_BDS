var TFunc = {
    setCookie: function (name, value, expires, path, domain, secure) {
        var today = new Date();
        today.setTime(today.getTime());
        var expires_date = new Date(today.getTime() + (expires));
        document.cookie = name + "=" + escape(value) + ((expires) ? ";expires=" + expires_date.toGMTString() : "") + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ((secure) ? ";secure" : "");
    },
    getCookie: function (name) {
        /*var re=new RegExp(Name+"=[^;]+", "i");             if (document.cookie.match(re))                  return decodeURIComponent(document.cookie.match(re)[0].split("=")[1]);              return null;*/
        var start = document.cookie.indexOf(name + "=");
        var len = start + name.length + 1;
        if ((!start) && (name != document.cookie.substring(0, name.length))) {
            return null;
        }
        if (start == -1) return null;
        var end = document.cookie.indexOf(";", len);
        if (end == -1) end = document.cookie.length;
        return unescape(document.cookie.substring(len, end));
    },
    deleteCookie: function (name, path, domain) {
        if (this.getCookie(name))
            document.cookie = name + "=" + ((path) ? ";path=" + path : "") + ((domain) ? ";domain=" + domain : "") + ";expires=Mon, 11-November-1989 00:00:01 GMT";
    },
    addEvent: function (obj, eventName, func) {
        if (obj.attachEvent) {
            obj.attachEvent("on" + eventName, func);
        }
        else if (obj.addEventListener) {
            obj.addEventListener(eventName, func, true);
        }
        else {
            obj["on" + eventName] = func;
        }
    }
};

function setLocation(n){
    window.location.href=n
}

/**
 * Scrollable
 */
function scrollToElement(id){
    jQuery('body,html').animate({
        scrollTop: jQuery(id).offset().top - 10
    }, 800);
}

/**
 * Check valid an email
 */
function isValidEmail(email) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(email);
}

/**
 * get clock
 * 
 * @param int type
 */
function getClock(disp){
    var curTime=new Date();
    var nhours=curTime.getHours();
    var nmins=curTime.getMinutes();
    var nsecn=curTime.getSeconds();
    var nday=curTime.getDay();
    var nmonth=curTime.getMonth();
    var ntoday=curTime.getDate();
    var nyear=curTime.getYear();
    var AMorPM=" ";
    if (nhours>=12)AMorPM="";
    else AMorPM="";
    if (nhours>=13)nhours-=12;
    if (nhours==0)nhours=12;
    if (nsecn<10)nsecn="0"+nsecn;
    if (nmins<10)nmins="0"+nmins;
    if (nday==0)nday="Chủ nhật";
    if (nday==1)nday="Thứ hai";
    if (nday==2)nday="Thứ ba";
    if (nday==3)nday="Thứ tư";
    if (nday==4)nday="Thứ năm";
    if (nday==5)nday="Thứ sáu";
    if (nday==6)nday="Thứ bảy";
    nmonth+=1;
    if (nyear<=99)nyear= "19"+nyear;
    if ((nyear>99) && (nyear<2000))nyear+=1900;
    var d;
    var Str0="";
    if (nhours>9) Str0 = "";
    else Str0 = "0";
    
    d= document.getElementById("theClock");
    var ouput = "";
    if(disp == 0){
        ouput = ntoday + "/" + nmonth + "/" + nyear + " " + Str0 + nhours + ":" + nmins + ":" + nsecn;
    }else{
        ouput = " <span>" + Str0 + nhours+" giờ "+nmins+" phút "+nsecn + " giây - " + AMorPM + "</span>" + nday+" - Ngày " + ntoday +" tháng " + nmonth + " năm " + nyear;
    }
    
    d.innerHTML = ouput;
    setTimeout('getClock(1)',1000);
}

/**
 * Set Bookmark
 */
function setBookmark(url, title){
    if (window.sidebar) // firefox
        window.sidebar.addPanel(title, url, "");
    else if(window.opera && window.print){ // opera
        var elem = document.createElement('a');
        elem.setAttribute('href',url);
        elem.setAttribute('title',title);
        elem.setAttribute('rel','sidebar');
        elem.click();
    }
    else if(document.all)// ie
        window.external.AddFavorite(url, title);
}

jQuery(function($){
    // Read a page's GET URL variables and return them as an associative array.
    $.extend({
        getUrlVars: function(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name){
            return $.getUrlVars()[name];
        }
    });
    
    // Escape regex chars with \
    var escape = function (text) {
        return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
    };
  
    // For those who need them (< IE 9), add support for CSS functions
    var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
    if (!isStyleFuncSupported) {
        CSSStyleDeclaration.prototype.getPropertyValue = function (a) {
            return this.getAttribute(a);
        };
        CSSStyleDeclaration.prototype.setProperty = function (styleName, value, priority) {
            this.setAttribute(styleName, value);
            var priority = typeof priority != 'undefined' ? priority : '';
            if (priority != '') {
                // Add priority manually
                var rule = new RegExp(escape(styleName) + '\\s*:\\s*' + escape(value) +
                        '(\\s*;)?', 'gmi');
                this.cssText =
                        this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
            }
        };
        CSSStyleDeclaration.prototype.removeProperty = function (a) {
            return this.removeAttribute(a);
        };
        CSSStyleDeclaration.prototype.getPropertyPriority = function (styleName) {
            var rule = new RegExp(escape(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?',
                    'gmi');
            return rule.test(this.cssText) ? 'important' : '';
        }
    }
  
    // The style function
    $.fn.style = function (styleName, value, priority) {
        // DOM node
        var node = this.get(0);
        // Ensure we have a DOM node
        if (typeof node == 'undefined') {
            return this;
        }
        // CSSStyleDeclaration
        var style = this.get(0).style;
        // Getter/Setter
        if (typeof styleName != 'undefined') {
            if (typeof value != 'undefined') {
                // Set style property
                priority = typeof priority != 'undefined' ? priority : '';
                style.setProperty(styleName, value, priority);
                return this;
            } else {
                // Get style property
                return style.getPropertyValue(styleName);
            }
        } else {
            // Get CSSStyleDeclaration
            return style;
        }
    };
});