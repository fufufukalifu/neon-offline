 <br>
<div class="container">
  <!-- row -->
  <div class="row">
    <!-- col-md-2 -->
    <div class="col-md-2">
    </div>
    <!--/ col-md-2 -->

     <!-- col-md-8 -->
    <div class="col-md-12">
      <!-- panel panel-default -->
      <div class="panel panel-default">
        <!-- panel heading/header -->
        <div class="panel-heading">
          <h3 class="panel-title">User Guide Siswa</h3>
        </div>
        <!--/ panel heading/header -->
        <!-- panel body -->
        <div class="panel-body">
          <div class="row">
    <div class="col-md-12">
      <!-- assets/pdf/user_guide/Tutorial-I-Latihan-Siswa.pdf -->
      <embed src="" width="100%" height="670" type='application/pdf' id='embed_pdf'>
      </div>
      <div class="col-md-3" id="list_ug">
        
        
      </div>
    </div>
        <!--/ panel body -->
      </div>
      <!-- panel panel-default -->
    </div>
    <!--/ col-md-8 -->
  </div>
  <!--/ row -->
</div>

<script type="text/javascript">
  var url_pdf="<?=base_url()?>assets/pdf/user_guide/Tutorial-Siswa.pdf";
    $(document).ready(function(){
      get_list_user_guide();
      set_pdf();
    });
    function set_pdf(){
      $("#embed_pdf").attr('src',url_pdf);
    }
    function get_list_user_guide(){
      var url=base_url+"help/get_list_user_guide";
      $.ajax({
        url:url,
        type:"post",
        dataType:"text",
        success:function(Data){
          var ob_data= JSON.parse(Data);
          $("#list_ug").append(ob_data);
        },
        error:function(){
          console.log("ada kesalahan");
        }
      });
    }
    function get_pdf_ug(id=''){
      var url=base_url+"help/get_pdf_user_guide";
      $.ajax({
        url:url,
        data:{id:id},
        type:"post",
        dataType:"text",
        success:function(Data){
          var ob_data= JSON.parse(Data);
          url_pdf="<?=base_url()?>assets/pdf/user_guide/"+ob_data+".pdf";
         set_pdf();
          // $("#list_ug").append(ob_data);

        },
        error:function(){
          console.log("ada kesalahan");
        }
      });
    }
  </script>
