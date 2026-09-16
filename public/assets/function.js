$(document).ready(function(){
mtd = {
  show_msgT:function(type, url='', msg='', act=0, info=''){

    var timeOut = '4000';
    var cllFn = '';
    
    $(function() {
      function call(){
        if(url != ''){
          var timeOutH = timeOut/2;
          timeOutH = timeOutH.toFixed(2);
          setTimeout(function() {  location=url; }, timeOutH  );
        }else{
          var fullurl = window.location.href;
          fullurl = fullurl.split("?");
          //var urlO = fullurl[0].trim();
          //window.history.pushState("", "", urlO);
        }
      }
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": timeOut,
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "onHidden": call(),
      }  
      var callMsg = '';
      type = parseInt(type);
      switch (type) {
        case 1: 
          // success
          toastr.success(msg.trim());
        break;
          case 2: 
          // error
          toastr.error(msg.trim());
        break;
          case 3: 
          // warning
          toastr.warning(msg.trim());
        break;
          case 4: 
          // info
          toastr.info(msg.trim());
        break;
        default:
          toastr.error(msg.trim());
        break;
      }
      setTimeout(function() {  callMsg }, 100);
    }); 
  },

  
  /////////////////////////////////////////////////////////////////////////
  show_msg:function(type=3, url='', msg='', act=0, info=''){
    var icon = '';    var tim = 6000000;
    if(type == 0){  icon = 'error';   }
    else if(type == 1){ icon = 'success';   tim = 4000;   }
    else if(type == 2){ icon = 'warning';   }
    else if(type == 3){ icon = 'info';   }
    else if(type == 4){ icon = 'success';   }
    else {  icon = 'warning'; msg='Not valid info.'; }
    
    var closBtn = cnfBtn = true;
    if(act==1){// insert
      cnclBtn = false;
      cnfBtnTxt = 'Ok';
      cnlBtnText = '';
    }
    else if(act==2){// update
      cnclBtn = true;
      cnfBtnTxt = 'Yes';
      cnlBtnText = 'No';
    }
    else if(act==3){// delete
      cnclBtn = true;
      cnfBtnTxt = 'Yes, Delete It.';
      cnlBtnText = 'Cancel';
    }
    else if(act==4){// wait
      cnfBtn = closBtn = cnclBtn = false;
      cnfBtnTxt = '';
      cnlBtnText = '';
    }
    else if(act == 5){ // yes with no timeout
      cnclBtn = false;
      cnfBtnTxt = 'Ok';
      cnlBtnText = '';
    }
    else{ // wrong type
      cnclBtn = false;
      cnfBtnTxt = 'Ok';
      cnlBtnText = 'Invalid';
    }
    url = url.trim();
    return Swal.fire({
      timer: tim,
      icon: icon,
      //title: 'Oops...',
      showCloseButton: closBtn,
      showCancelButton: cnclBtn,
      showConfirmButton: cnfBtn,
      html: msg,
      confirmButtonText: cnfBtnTxt,
      cancelButtonText: cnlBtnText,
      footer: '<table style="text-align: center; width:100%;"><tr><td><img src="http://abatechcal.com/img/Abacus-Icon.png" style="width:30px; height:30px;"/></td><td><i class="fa fa-copyright"></i><a style="text-decoration:none;" href="http://abatechcal.com/" target="_blank">Abatech Solutions</a></td></tr></table>',
      showClass: { popup: 'animate__animated animate__fadeInDown'   },
      hideClass: { popup: 'animate__animated animate__fadeOutUp'    },
      onClose: () => {  
        if (type == '1' && url != '') {
          window.location=url;
        }   
      },
    }).then((result) => {
      if (result.value && parseInt(act) == 3 && url != '') {
        window.location=url;
      }else if (result.value && parseInt(act) == 2 && url != '') {
        window.location=url;
      }else if (result.value && url != '') {
        window.location=url;
      }
    });
  },
  /////////////////////////////////////////////////////////////////////////
	s_nam:function(get_id, set_id, space=1, optn=0){
    var full_name = $(get_id).val();
    if(full_name.length > 0){
      if(space == '0'){
        short_name = full_name;
        if(optn == '1'){
          short_name = $(get_id).find('option:selected').text();
        }
      }else{
        full_name = full_name.replace(/\s+/g, '');
        short_name = full_name.substr(0, 10);
      }
      $(set_id).val(short_name);
    }else{
      $(set_id).val('');
    }
  },
  /////////////////////////////////////////////////////////////////////////
  s_nam3:function(get_id, set_id, space=1, optn=0){
    var full_name = $(get_id).val();
    if(full_name.length > 0){
      if(space == '0'){
        short_name = full_name;
        if(optn == '1'){
          short_name = $(get_id).find('option:selected').text();
        }
      }else{
        full_name = full_name.replace(/\s+/g, '');
        short_name = full_name.substr(0, 3);
      }
      $(set_id).val(short_name);
    }else{
      $(set_id).val('');
    }
  },
  //////////////////////////////////////////////////////////
  tk_act:function(thiss){
    var act = $(thiss).val();
    var id = $(thiss).attr('data-id');
    var hsacls = $(thiss).hasClass('btnO');
    if(hsacls){
      var pag = $(thiss).attr('data-pag');
    }else{
      var pag = $(thiss).find('option:selected').attr('data-pag');
    }
    

    var add = $(thiss).find('option:selected').attr('data-add');
    var add_new = '';
    if(add != undefined){
      var add_new = add;
    }
    //alert(act+' - '+id+' - '+pag);
    if(act > 0 && pag != ''){
      if(act == 1 || act == 2){
          info = id;
          this.urlEncDec(info, 'e', act, pag);
      }else if(act == 3){
          //d_pag = pag+'?act='+act+'&id='+id+add_new;
          info = id;
          mtd.show_msg(2, pag, 'Are you sure to delete it.', 3, info);
      }else if(act == 4){
          //window.location=pag+'?act='+act+'&id='+id+add_new;
          info = id;
          this.urlEncDec(info, 'e', act, pag, 'B');
      }else{
         $(thiss).val(0); 
      }
    }
  },
  getQrCode:function(qrData){
    $.ajax({
      async: false,
      type: "POST",
      url: "_ajax2.php",
      data: "qrData="+qrData+"&getQrCode=getQrCode",
      success: function (data_content){
        data_content = data_content.trim();
        //console.log(data_content);
        data_content = data_content.split('^');
        var qr_content = data_content[1];
        var qr_tblNam = 'table '+data_content[2];
        
        $('.showDiv .table').attr('data-tablename', qr_tblNam);
        $('.qrShowDiv').html(qr_content);
        $('#qrModal').css('display', 'block');
        
        setTimeout(function(){ 
          $('.printQR').trigger('click');
        }, 2000);
        setTimeout(function(){ 
          //$('#qrModal').css('display', 'none');
        }, 3000);
        
      }
    });
  },
  ///////////////////////////////////////////////////////////
  changeLook:function(){
  	var config = {
  		'.chosen-select' : {}
  	}
  	for (var selector in config) {
  		$(selector).chosen(config[selector]);
  	}
  },
  ///////////////////////////////////////////////////////
  remove00:function(){
    $('td, th').each(function() {
      if($(this).closest('.print').length) return;
      if($(this).closest('#invoiceTable').length) return;
      var xyz = $(this).text();
	  xyz = xyz.trim();
      // if(xyz == '0.00' || xyz == '00' || xyz == '0' || xyz == '0.0' || xyz == '0.000'){
      //   $(this).text('');
      // }
    });
  },
  ///////////////////////////////////////////////////////
  tAmPm:function(time){
    time = time.trim();
    time = time.split(':');
    var hh = time[0];
    var mm = time[1];
    var mrd = 'AM';
    if(parseInt(hh) >= 12 && parseInt(mm) >= 0){
      mrd = 'PM';
      hh = parseInt(hh) - 12;
    }
    if(hh < 10){    hh = '0'+hh;    }
    var new_tm = hh+':'+mm+' '+mrd;
    return new_tm;
  },
  ///////////////////////////////////////////////////////
  changeDate: function(thiss, dt_cls) {
    var btnId = thiss.id;
    var d = new Date();
    var mm = d.getMonth() + 1;
    if (mm < 10) {
        mm = '0' + mm;
    }
    var dd = d.getDate();
    if (dd < 10) {
        dd = '0' + dd;
    }
    var toDay = d.getFullYear() + "-" + mm + "-" + dd;

    var input_date = $(dt_cls).val();
    var input_date = new Date(input_date);
    var new_date = i_date = new Date(input_date);
    var days = (btnId == "dtNxt") ? 1 : -1;

    $("#dtNxt").removeAttr('disabled');

    var toDay = new Date(toDay);

    if (Date.parse(i_date) === Date.parse(toDay) && btnId == "dtNxt") {
        $("#dtNxt").attr('disabled', 'disabled');
        return false;
    }
    i_date.setDate(i_date.getDate() + days);

    var mm2 = i_date.getMonth() + 1;
    if (mm2 < 10) {
        mm2 = '0' + mm2;
    }
    var dd2 = i_date.getDate();
    if (dd2 < 10) {
        dd2 = '0' + dd2;
    }

    var new_date = i_date.getFullYear() + "-" + mm2 + "-" + dd2;
    $(dt_cls).attr('value', new_date).val(new_date);
  },
  ///////////////////////////////////////////////////////
  searchRecord:function(thiss, tblId){
    var value = $(thiss).val().toLowerCase();
    $(tblId+" tr").filter(function() {
      $(this).toggle($(this).find('td:eq(0)').text().toLowerCase().indexOf(value) > -1)
    });
  },
  ///////////////////////////////////////////////////////
  act_dectv:function(thiss, code){
    var user_typ = $(thiss).closest('tbody').attr('data-user');
    var btn_val = $(thiss).val();
    var pg_typ = $(thiss).closest('tbody').attr('data-peg');
    if(btn_val == 1){      
      var act = 3; var type = "deactivate";
    }else{
      var act = 4; var type = "activate";
    }
    d_pag = pg_typ+'?act='+act+'&id='+code+'&usercd='+user_typ;
    mtd.show_msg(2, d_pag, 'Are you sure to '+type+' it.', 2);
  },
  ///////////////////////////////////////////////////////
  btnEditDel:function(thiss, act, url, info, target=''){
    if(info.trim() == ''){
      mtd.show_msgT(2, '', 'Please initilize click value. ', 2);
      return false;
    }
    if(parseInt(act) == 0 && info.toUpperCase() == 'GET'){
      var vl = $(thiss).val();
      var tag = $(thiss).attr('data-tag');
      var info = tag+'='+vl;
      this.urlEncDec(info, 'e', act, url, target);
    }else if((parseInt(act) == 2 || parseInt(act) == 4) && info.trim() != ''){
      this.urlEncDec(info, 'e', act, url, target);
    }
  },
  ///////////////////////////////////////////////////////
  urlEncDec:function(info, ed, act, url, target=''){
    $.ajax({
      cache: false,
      type: "POST",
      url: "_ajax.php",
      data: "ajaxSubmit=urlEnDn&info="+info+"&ed="+ed,
      beforeSend: function(){
        //mtd.show_msg(3, '', 'Please wait...!', 4);
      },
      success: function (data_content){
        data_content = data_content.trim();
        data_content = data_content.split('^');
        var data = data_content[1];
        target = target.toUpperCase();
        console.log(url+'?act='+act+'&info='+data);
        if(target == 'B'){
          window.open(url+'?act='+act+'&info='+data, '_blank');
        }else{
          location = url+'?act='+act+'&info='+data;
        }
      }
    });
  },
  ///////////////////////////////////////////////////////
  getStateList:function(thiss, statecls){
    var countrycd = $(thiss).val();
    var statecd = $(statecls).attr('data-statecd');
    if(parseInt(countrycd) > 0){
      $.ajax({
        type: "POST",
        url: "_ajax.php",
        data: "ajx_submit=getStateList&countrycd="+countrycd,
        success: function (data_content){
          data_content = data_content.trim();
          //console.log(data_content);
          data_content = data_content.split('^');
          var stateList = data_content[1];
          $(statecls).html(stateList).trigger('chosen:updated');
          if(parseInt(statecd) > 0){
            $(statecls).val(statecd).trigger('chosen:updated');
          }
        }
      });
    }
  },
  ///////////////////////////////////////////////////////
  menuPage:function(thiss){
    var menuInfo = $(thiss).attr('data-menuinfo');
    var pgYN = $(thiss).attr('data-pg');
    if(parseInt(pgYN) == 1){
      $.ajax({
        type: "POST",
        url: "_ajax.php",
        data: "ajaxSubmit=menuPageSetting&menuInfo="+menuInfo,
        success: function (data_content){
          data_content = data_content.trim();
          data_content = data_content.split('^');
          var page = data_content[1];
          var pgYNN = data_content[2];
          var dshPg = data_content[3];
          var nextPage = dshPg;
          if(pgYNN == '1'){
            nextPage = page;
          }
          location = nextPage;
        }
      });
    }
  },
  ///////////////////////////////////////////////////////
  calEDAmount:function(thiss, ed, page=''){
    if(page == 'salary_register'){
      var srlno_cur = 1;
    }else{
      var tbody = $(thiss).closest('.edTbody');
      var srlno_cur = $(thiss).closest('.trr').attr('data-srlno');
      var value = $(thiss).val();
    }
    if(ed == 'E'){
      ///// for earning
      $('.edTbodyEarn .trr').each(function(index){
        var amount = 0;
        var srlno = $(this).attr('data-srlno');
        var percentage = $(this).attr('data-per');
        var tag = $(this).attr('data-tag');
        var tag = parseInt(tag);
        var formula = $(this).attr('data-formula');
        var formula = formula.trim();
        if(parseInt(srlno) > parseInt(srlno_cur) && formula != '' && parseFloat(percentage) > 0){
          formula = formula.split(',');
          $(formula).each(function(index2, val2) {
            var amt = $('.trr_'+val2).find('.amnt').val();
            if(amt <= 0 || amt == undefined || amt == ''){
              amt = 0;
            }
            amount = parseFloat(amount) + parseFloat(amt); 
          });
          var amt_ttl = parseFloat(amount) * parseFloat(percentage) / 100; 
          var amt_ttl = amt_ttl.toFixed(2);
          $(this).find('.amnt').attr('value', amt_ttl).val(amt_ttl);
        }
      });
    }


    //// for deduction
    if(page == 'salary_register'){
      var div = $('#mdlSalRegEdit');
    }else{
      var div = $('#custom-tabs-four-other');
    }
    $('.edTbodyDeduct .trr').each(function(index){
      var amount = 0;
      var srlno = $(this).attr('data-srlno');
      var percentage = $(this).attr('data-per');
      var tag = $(this).attr('data-tag');
      var tag = parseInt(tag);
      var formula = $(this).attr('data-formula');
      var formula = formula.trim();
      var calAmtYn = 'N';
      var tagsObj = { 4: 'PF', 5: 'FPF', 6: 'ESI', 7: 'P.Tax' };
      if (tagsObj[tag] !== undefined) {
        console.log('Key', tag, 'exists in tagsObj');
        var amt_ttl = 0;
        $(this).find('.amnt').attr('value', amt_ttl).val(amt_ttl);
        switch(tag){
          case 4:
            calAmtYn = div.find('.pfyn').val();
          break;
          case 5:
            calAmtYn = div.find('.fpfyn').val();
          break;
          case 6:
            calAmtYn = div.find('.esiyn').val();
          break;
          case 7:
            calAmtYn = div.find('.ptaxyn').val();
          break;
          default:
            calAmtYn = 'N';
          break;
        }
      }else{
        calAmtYn = 'Y';
      }
      var ttlAmount = 0;
      if(formula != '' && calAmtYn == 'Y'){
        //console.log("srlno="+srlno, "formula="+formula);
        formula = formula.split(',');
        $(formula).each(function(index2, val2) {
          var amt = $('.trr_'+val2).find('.amnt').val();
          if(amt <= 0 || amt == undefined || amt == ''){
            amt = 0;
          }
          ttlAmount = amount = parseFloat(amount) + parseFloat(amt); 
        });
        var amt_ttl = parseFloat(amount) * parseFloat(percentage) / 100; 
            amt_ttl = amt_ttl.toFixed(2);

        if(tag == 7){
          //console.log("tag="+tag+", amt_ttl="+amt_ttl);
          $.ajax({
            async: false,
            type: "POST",
            url: "_ajaxU.php",
            data: {ajaxSubmit: "calculateEdAmount", tag: tag, amt: ttlAmount },
            success: function(response){
              // console.log(response+'-->');
              response = response.split('^');
              amt_ttl = parseFloat(response[1]);
              amt_ttl = amt_ttl.toFixed(2);
            }
          });
        }
        $(this).find('.amnt').attr('value', amt_ttl).val(amt_ttl);
      }
    });

    ////// caculate total
    var gross_earn = gross_deduct = net_payable = 0;

    $('.edTbodyEarn .trr').each(function(index){
      var earn = $(this).find('.amnt').val();
      if(earn <= 0 || earn == undefined || earn == ''){
        earn = 0;
      }
      gross_earn = parseFloat(gross_earn) + parseFloat(earn); 
      gross_earn = gross_earn.toFixed(2);
    });
    $('.edTbodyDeduct .trr').each(function(index){
      var deduct = $(this).find('.amnt').val();
      if(deduct <= 0 || deduct == undefined || deduct == ''){
        deduct = 0;
      }
      gross_deduct = parseFloat(gross_deduct) + parseFloat(deduct); 
      gross_deduct = gross_deduct.toFixed(2);
    });
    net_payable = parseFloat(gross_earn) - parseFloat(gross_deduct); 
    net_payable = net_payable.toFixed(2);
    console.log(thiss);
    if(net_payable < 0){
      mtd.show_msgT(0,'','Net Amount cannot be Neagative...',0);
      $('.btnUpdateSalary').attr('disabled','disabled');
    }else{$('.btnUpdateSalary').removeAttr('disabled');}

    $('.gern').attr('value', gross_earn).val(gross_earn);
    $('.gded').attr('value', gross_deduct).val(gross_deduct);
    $('.npay').attr('value', net_payable).val(net_payable);
  },
}
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
mtd.remove00();
var cs = $('body').find('.chosen-select').length;
if(cs > 0){
  mtd.changeLook();
}
$('form input').attr('autocomplete', 'off');

$(document).on('keyup', 'input, textarea' , function() {
  var tp = $(this).attr('type');
  if(tp == 'time' || tp == 'date' || tp == 'radio' || tp == 'checkbox'  || tp == 'color'){
    return false;
  }
	var txt = $(this).val();
	txt = txt.trim();
	if(txt == ''){
  		$(this).val('');
	} 
});


////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
	$(document).on('keyup', 'input[type="text"]', function(){
		var value = $(this).val();
		value = value.trim();
		if(value == ''){
			$(this).val('');
		}
	});
////////////////////////////////////////////////////////
 	$(".float").on("keypress keyup blur",function (event) {
		//this.value = this.value.replace(/[^0-9\.]/g,'');
		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
		
		if (event.type === "blur") {
      var val = parseFloat($(this).val());
      if (isNaN(val) || val < 0.01) { 
          $(this).val(''); 
      }
    }
	});

	
//////////////////////////////////////////////////////////////
	$(".int").on("keypress keyup blur",function (event) {    
	   $(this).val($(this).val().replace(/[^\d].+/, ""));
	    if ((event.which < 48 || event.which > 57)) {
	        event.preventDefault();
	    }
	});
////////////////////////////////////////////////////////////
	$('.char').on("keypress keyup blur",function (e) { 
	var key = e.keyCode;
		if (!((key == 8) || (key == 32) || (key == 46) || (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (e.shiftKey || e.ctrlKey || e.altKey))) {
		  e.preventDefault();
		}	 
	});
////////////////////////////////////////////////////////////
  $('input[maxlength]').on("keyup", function (e) { 
    var val = $(this).val();
    var maxlen = $(this).attr('maxlength');
    if(parseInt(val) > parseInt(maxlen)){
      val = val.substr(0, parseInt(maxlen));
    }
    $(this).val(val);
  });
/////////////////////////////////////////////////
  $('.form-control:eq(0)').not('.inputFCS').focus();
  //////////////////////////////////////////////////////
  $(".newTabPg").on("contextmenu", function (e) {
      // Prevent the default right-click context menu
      e.preventDefault();
      
      // Get the link's href attribute
      var linkHref = $(this).attr("data-link");
      var linkPgYn = $(this).attr("data-pg");
      if(parseInt(linkPgYn) == 1){
        window.open(linkHref, "_blank");
      }
  });
});
/////////////////////////////////////////////////////////////////

