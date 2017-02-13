<div class="row">

</div>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"> 

     </h3>


     <div class="panel-toolbar text-right">
       <div class="col-sm-4 mt10">

         <span><b>Try Out: </b></span>
         <i class="ico-file-check mt10"></i>  
       </div>
       <div class="col-sm-8">

         <!-- stkt = soal tingkat -->
         <select class="form-control" name="masa_aktif" id="masa_aktif_select">
          <option value="all">Pilih</option>
          <?php foreach ($to as $item): ?>
          <option value="<?=$item['id_tryout']?>"><?=$item['nm_tryout'] ?></option>
        <?php endforeach ?>
      </select>


    </div>
  </div>
</div>
<div class="panel-body">
  <div class="col-lg-3">
    <div class="panel panel-default">
      <!-- panel heading/header -->
      <div class="panel-heading">
        <div class="panel-title">Partisipasi</div>
        <!-- panel toolbar -->
        <div class="panel-toolbar text-right">
          <!-- option -->
          <div class="option">
            <button class="btn" data-toggle="panelrefresh"><i class="reload"></i></button>
            <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
            <button class="btn" data-toggle="panelremove" data-parent=".col-md-4"><i class="remove"></i></button>
          </div>
          <!--/ option -->
        </div>
        <!--/ panel toolbar -->
      </div>
      <!--/ panel heading/header -->
      <!-- panel body with collapse capabale -->
      <div class="panel-collapse pull out">
        <div class="panel-body">
          <!-- Loading indicator -->
          <div class="indicator"><span class="spinner"></span></div>
          <!--/ Loading indicator -->
          <div class="chart mt10" id="chart_partisipasi" style="height: 250px; padding: 0px; position: relative;">

          </div>

        </div>
        <!--/ panel body with collapse capabale -->
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="panel panel-default">
      <!-- panel heading/header -->
      <div class="panel-heading">
        <div class="panel-title">TO Selesai</div>
        <!-- panel toolbar -->
        <div class="panel-toolbar text-right">
          <!-- option -->
          <div class="option">
            <button class="btn" data-toggle="panelrefresh"><i class="reload"></i></button>
            <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
            <button class="btn" data-toggle="panelremove" data-parent=".col-md-4"><i class="remove"></i></button>
          </div>
          <!--/ option -->
        </div>
        <!--/ panel toolbar -->
      </div>
      <!--/ panel heading/header -->
      <!-- panel body with collapse capabale -->
      <div class="panel-collapse pull out">
        <div class="panel-body">
          <!-- Loading indicator -->
          <div class="indicator"><span class="spinner"></span></div>
          <!--/ Loading indicator -->
          <div class="chart mt10" id="chart-bar" style="height: 250px; padding: 0px; position: relative;">

          </div>
        </div>
        <!--/ panel body with collapse capabale -->
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="panel panel-default">
      <!-- panel heading/header -->
      <div class="panel-heading">
        <div class="panel-title">Paket Selesai</div>
        <!-- panel toolbar -->
        <div class="panel-toolbar text-right">
          <!-- option -->
          <div class="option">
            <button class="btn" data-toggle="panelrefresh"><i class="reload"></i></button>
            <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
            <button class="btn" data-toggle="panelremove" data-parent=".col-md-4"><i class="remove"></i></button>
          </div>
          <!--/ option -->
        </div>
        <!--/ panel toolbar -->
      </div>
      <!--/ panel heading/header -->
      <!-- panel body with collapse capabale -->
      <div class="panel-collapse pull out">
        <div class="panel-body">
          <!-- Loading indicator -->
          <div class="indicator"><span class="spinner"></span></div>
          <!--/ Loading indicator -->
          <div class="chart mt10" id="chart-bar" style="height: 250px; padding: 0px; position: relative;">

          </div>
        </div>
        <!--/ panel body with collapse capabale -->
      </div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="panel panel-default">
      <!-- panel heading/header -->
      <div class="panel-heading">
        <div class="panel-title">Call CS</div>
        <!-- panel toolbar -->
        <div class="panel-toolbar text-right">
          <!-- option -->
          <div class="option">
            <button class="btn" data-toggle="panelrefresh"><i class="reload"></i></button>
            <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
            <button class="btn" data-toggle="panelremove" data-parent=".col-md-4"><i class="remove"></i></button>
          </div>
          <!--/ option -->
        </div>
        <!--/ panel toolbar -->
      </div>
      <!--/ panel heading/header -->
      <!-- panel body with collapse capabale -->
      <div class="panel-collapse pull out">
        <div class="panel-body">
          <!-- Loading indicator -->
          <div class="indicator"><span class="spinner"></span></div>
          <!--/ Loading indicator -->
          <div class="chart mt10" id="chart-bar" style="height: 250px; padding: 0px; position: relative;">

          </div>
        </div>
        <!--/ panel body with collapse capabale -->
      </div>
    </div>
  </div>
</div>
</div>





</div>
