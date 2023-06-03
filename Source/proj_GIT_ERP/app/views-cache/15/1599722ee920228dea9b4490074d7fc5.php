<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* footer.html */
class __TwigTemplate_8c269c7beb49203438a4bb7d43d812fa extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "  <!-- Control Sidebar -->
  <aside class=\"control-sidebar control-sidebar-dark\">
    <!-- Control sidebar content goes here -->
    <div class=\"p-3\">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class=\"main-footer\">
    <!-- To the right -->
    <div class=\"float-right d-none d-sm-inline\">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong> Developed by <a href=\"https://www.linkedin.com/in/emanuel-f-costa-0446b965/\" target=\"_blank\">Emanuel F. Costa</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src=\"/res/admin/plugins/jquery/jquery.min.js\"></script>
<!-- Bootstrap 4 -->
<script src=\"/res/admin/plugins/bootstrap/js/bootstrap.bundle.min.js\"></script>
<!-- AdminLTE App -->
<script src=\"/res/admin/dist/js/adminlte.min.js\"></script>

<script src=\"/res/admin/plugins/datatables/jquery.dataTables.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js\"></script>
<script src=\"/res/admin/plugins/jszip/jszip.min.js\"></script>
<script src=\"/res/admin/plugins/pdfmake/pdfmake.min.js\"></script>
<script src=\"/res/admin/plugins/pdfmake/vfs_fonts.js\"></script>
<script src=\"/res/admin/plugins/datatables-buttons/js/buttons.html5.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-buttons/js/buttons.print.min.js\"></script>
<script src=\"/res/admin/plugins/datatables-buttons/js/buttons.colVis.min.js\"></script>


<script src=\"/res/admin/dist/js/adminlte.min.js?v=3.2.0\"></script>

<script type=\"module\" src=\"https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js\"></script>
<script nomodule src=\"https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js\"></script>


<script>
  \$(function () {
    
    \$('#tb_grupos').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });
//----------------------------------------
  \$(function () {
    
    \$('#tb_products').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });

  //-------------------------------------------

  \$(function () {
    
    \$('#tb_suppliers').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });

  //-------------------------------------------

  \$(function () {
    
    \$('#tb_clients').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });
  //---------------------------------------
  \$(function () {
    
    \$('#tb_paymentmethods').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });
//---------------------------------------
\$(function () {
    
    \$('#tb_sales').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });
  //-------------------------------------------
  \$(function () {
    
    \$('#tb_purchases').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });
  //-----------------------------------------------
  \$(function () {
    
    \$('#tb_accountpayable').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      \"responsive\": true,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });
  });


  //-----------------------------------------

  \$(function () {
  \$('#gridproducts').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });

  });
    //--------------------------------------------
  \$(function () {
    
    \$('#gridclientsale').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });

  });

  //----------------------------------------
  \$(function () {
    
    \$('#gridcost_centersale').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });

  });

  //----------------------------------------
  \$(function () {
    
    \$('#gridpayment_method_sale').DataTable({
      \"paging\": true,
      \"lengthChange\": true,
      \"searching\": true,
      \"ordering\": true,
      \"info\": true,
      \"autoWidth\": false,
      // \"language\": {
      //       \"url\": \"//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json\"
      //   }
    });

  });

 //---------------------------------------------
function changeDateFormat(inputDate){  // expects Y-m-d
    var splitDate = inputDate.split('-');
    if(splitDate.count == 0){
        return null;
    }

    var year = splitDate[0];
    var month = splitDate[1];
    var day = splitDate[2]; 

    return day + '/' + month + '/' + year;
}
//

\$(function () {

\$('#v_value_disc_perc_cash').focusin(function(){

  document.getElementById('v_value_disc_perc_cash').value = 0;
})

//------------------------------------------------
\$('#v_value_disc_perc_cash').focusout(function(){

var value_percentage_discount = document.getElementById('v_value_disc_perc_cash').value;
        
        
value_percentage_discount = convert_decimal_value(value_percentage_discount);


if(isNaN(value_percentage_discount)){
         
          swal('Warning!!!', 'The Discount must be a number! ', 'warning');
         
         document.getElementById('v_value_disc_perc_cash').value = 0;
         
         return false;     
     }
     document.getElementById('v_sale_value_after_desc').value =    

     (parseFloat(convert_decimal_value(document.getElementById('v_sale_value_cash').innerHTML)) -

     ((parseFloat(convert_decimal_value(document.getElementById('v_sale_value_cash').innerHTML))
     * parseFloat(convert_decimal_value(document.getElementById('v_value_disc_perc_cash').value)))/100)).toFixed(2);
     
     

})
//------------------------------------------

\$('#v_value_received_cash').focusout(function(){
          
          
          var value_received = document.getElementById('v_value_received_cash').value;
          
          
             value_received = convert_decimal_value(value_received);
      
       if(isNaN(value_received)){
           
            swal('Warning!!!', 'The Received value must be a number! ', 'warning');
           
           return false;     
       }
          
          
      
          
     
           document.getElementById('v_change_incache').value =    
          (parseFloat(convert_decimal_value(document.getElementById('v_value_received_cash').value)) 
           - parseFloat(document.getElementById('v_sale_value_after_desc').value)).toFixed(2); 
        
          
          
          // substitui a vírgula por ponto para não da problema no jason
          
          //console.log(document.getElementById('VALORRECEBIDO').value);

         //  document.getElementById('VALORRECEBIDO').value = document.getElementById('VALORRECEBIDO').value.replace(',','.');
          
            
   
              
              
              
          

        })

      })

  //-------------------------------------------

function isValidDate(dateString) {
  
  return dateString instanceof Date && !isNaN(dateString);
  
  // se a data é valida no formato YYYY-MM-DD que é o formato 
  // que sai do componente
  var regEx = /^\\d{4}-\\d{2}-\\d{2}\$/;
  if(!dateString.match(regEx)) return false;  // Invalid format
  var d = new Date(dateString);
  var dNum = d.getTime();
  if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
  return d.toISOString().slice(0,10) === dateString;
  
}





//--------------------------------------------------


 



</script>



</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "footer.html";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "footer.html", "/Users/emanuel/Documents/emanuel/projetos_php2023/proj_GIT_ERP/app/views/site/footer.html");
    }
}
