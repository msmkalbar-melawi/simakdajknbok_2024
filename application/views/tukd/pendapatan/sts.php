<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>easyui/jquery.edatagrid.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert-master/dist/sweetalert2.css" />

  <link href="<?php echo base_url(); ?>easyui/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>easyui/jquery-ui.min.js"></script>
  <script type="text/javascript">
    var kode = '';
    var giat = '1';
    var nomor = '';
    var cid = 0;
    var plrek = '';
    var lcstatus = '';
    //var tanggalterima = '';

    $(document).ready(function() {
      $("#accordion").accordion();
      $("#dialog-modal").dialog({
        height: 200,
        width: 700,
        modal: true,
        autoOpen: false
      });
      $("#dialog-modal_t").dialog({
        height: 500,
        width: 800,
        modal: true,
        autoOpen: false
      });
      $("#dialog-modal_cetak").dialog({
        height: 200,
        width: 400,
        modal: true,
        autoOpen: false
      });
      $("#dialog-modal_edit").dialog({
        height: 200,
        width: 700,
        modal: true,
        autoOpen: false
      });
      get_skpd();
      get_tahun();
    });

    //datagrid list sts
    $(function() {
      $('#dg').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/Penyetoran/load_sts',
        idField: 'id',
        rownumbers: "true",
        fitColumns: "true",
        singleSelect: "true",
        autoRowHeight: "false",
        loadMsg: "Tunggu Sebentar....!!",
        pagination: "true",
        nowrap: "true",
        columns: [
          [{
              field: 'no_sts',
              title: 'Nomor STS',
              width: 50
            },
            {
              field: 'tgl_sts',
              title: 'Tanggal',
              width: 30
            },
            {
              field: 'kd_skpd',
              title: 'S K P D',
              width: 30,
              align: "left"
            },
            {
              field: 'keterangan',
              title: 'Uraian',
              width: 50,
              align: "left"
            },
            {
              field: 'simbol',
              title: 'SPJ',
              width: 10,
              align: "left"
            }
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          nomor = rowData.no_sts;
          //nomor_kas     = rowData.no_kas;
          tgl = rowData.tgl_sts;
          //tgl_kas       = rowData.tgl_kas;
          kode = rowData.kd_skpd;
          lckdbank = rowData.kd_bank;
          lckdgiat = rowData.kd_sub_kegiatan;
          lcket = rowData.keterangan;
          lcjnskeg = rowData.jns_trans;
          lcrekbank = rowData.rek_bank;
          status = rowData.status;
          lno_terima = rowData.no_terima;
          lno_cek = rowData.no_cek;
          lctotal = rowData.total;
          jenis_status = rowData.sumber;
          spj = rowData.spj;
          get(nomor, tgl, kode, lckdbank, lckdgiat, lcket, lcjnskeg, lcrekbank, lctotal, jenis_status, lno_terima, spj, lno_cek, status);
          load_detail(nomor);
          lcstatus = 'edit';
        },
        onDblClickRow: function(rowIndex, rowData) {
          section2();
        }
      });

      $('#dg_tetap').edatagrid({
        url: '<?php echo base_url(); ?>/index.php/Penyetoran/load_tetap_sts/' + kode + '/' + plrek,
        idField: 'id',
        rownumbers: "true",
        fitColumns: "false",
        autoRowHeight: "false",
        loadMsg: "Tunggu Sebentar....!!",
        pagination: "true",
        nowrap: "true",
        columns: [
          [{
              field: 'ck',
              title: 'Pilih',
              width: 5,
              align: "center",
              checkbox: true
            },
            {
              field: 'no_tetap',
              title: 'Nomor Tetap',
              width: 10,
              align: "center"
            },
            {
              field: 'tgl_tetap',
              title: 'Tanggal',
              width: 5,
              align: "center"
            },
            {
              field: 'nilai',
              title: 'Nilai',
              width: 5,
              align: "center"
            }
          ]
        ]
      });


      $('#dg1').edatagrid({
        toolbar: '#toolbar',
        rownumbers: "true",
        fitColumns: "true",
        singleSelect: "true",
        autoRowHeight: "false",
        loadMsg: "Tunggu Sebentar....!!",
        nowrap: "true",
        onSelect: function(rowIndex, rowData) {
          idx = rowIndex;
          lnnilai = rowData.rupiah;
        },
        columns: [
          [{
              field: 'id',
              title: 'ID',
              hidden: "true"
            },
            {
              field: 'no_sts',
              title: 'No STS',
              hidden: "true"
            },
            {
              field: 'kd_rek6',
              title: 'Nomor Rekening',
              width: 1
            },
            {
              field: 'nm_rek',
              title: 'Nama Rekening',
              width: 3
            },
            {
              field: 'rupiah',
              title: 'Rupiah',
              align: 'right',
              width: 1
            },
            {
              field: 'sumber',
              title: 'Lokasi',
              hidden: "true",
              align: 'right',
              width: 1
            },
            {
              field: 'nm_pengirim',
              title: 'Nm Lokasi',
              align: 'right',
              width: 1
            }
          ]
        ],
        onDblClickRow: function(rowIndex, rowData) {
          idx = rowIndex;
          lcrekedt = rowData.kd_rek6;
          lcnmrekedt = rowData.nm_rek;
          lcnilaiedt = rowData.rupiah;
          //get_edt(lcrekedt,lcnmrekedt,lcnilaiedt); 
        }
      });

      $('#tanggalterima').datebox({
        required: true,
        formatter: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          return y + '-' + m + '-' + d;
        },
        onSelect: function(date) {
          tglterima();
        }
      });

      $('#tanggal').datebox({
        required: true,
        formatter: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          return y + '-' + m + '-' + d;
        },
        onSelect: function(date) {
          cek_status_spj();
        }
      });

      $('#tglvalid1').datebox({
        required: true,
        formatter: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          return y + '-' + m + '-' + d;
        },
        onSelect: function(date) {}
      });

      $('#tglvalid2').datebox({
        required: true,
        formatter: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          return y + '-' + m + '-' + d;
        },
        onSelect: function(date) {}
      });

      $('#tanggalkas').datebox({
        required: true,
        formatter: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          return y + '-' + m + '-' + d;
        },
        onSelect: function(date) {
          var y = date.getFullYear();
          var m = date.getMonth() + 1;
          var d = date.getDate();
          $("#tanggal").datebox("setValue", y + '-' + m + '-' + d);

        }
      });


      $('#rek').combogrid({
        panelWidth: 700,
        idField: 'kd_rek6',
        textField: 'kd_rek6',
        mode: 'remote',
        url: '<?php echo base_url(); ?>index.php/Penyetoran/ambil_rek_tetap/' + kode,
        columns: [
          [{
              field: 'kd_rek6',
              title: 'Kode Rekening',
              width: 140
            },
            {
              field: 'nm_rek',
              title: 'Uraian',
              width: 700
            },
          ]
        ],

        onSelect: function(rowIndex, rowData) {
          plrek = rowData.kd_rek6;
          $("#nmrek1").attr("value", rowData.nm_rek.toUpperCase());
          $("#dg_tetap").edatagrid({
            url: '<?php echo base_url(); ?>/index.php/Penyetoran/load_tetap_sts/' + kode + '/' + plrek
          });
        }
      });

      // $('#cmb_sts').combogrid({
      //   panelWidth: 700,
      //   idField: 'no_sts',
      //   textField: 'no_sts',
      //   mode: 'remote',
      //   url: '<?php echo base_url(); ?>index.php/Penyetoran/load_sts',
      //   columns: [
      //     [{
      //         field: 'no_sts',
      //         title: 'Nomor STS',
      //         width: 100
      //       },
      //       {
      //         field: 'kd_skpd',
      //         title: 'Nama SKPD',
      //         width: 700
      //       }
      //     ]
      //   ],
      //   onSelect: function(rowIndex, rowData) {
      //     nomor = rowData.no_sts;
      //   }
      // });

    
      //combo box no_terima
      $('#noterima').combogrid({
        
        url: '<?php echo base_url(); ?>index.php/Penyetoran/list_no_terima/2021-01-01',
        panelWidth: 800,
        idField: 'no_terima',
        textField: 'no_terima',
        mode: 'remote',
        fitColumns: true,
        columns: [
          [{
              field: 'no_terima',
              title: 'No Terima',
              width: 230
            },
            {
              field: 'kd_rek6',
              title: 'Kode Rekening',
              width: 100
            },
            {
              field: 'nilai',
              title: 'Total',
              align: 'left',
              width: 70
            },
            {
              field: 'nm_pengirim',
              title: 'Lokasi',
              align: 'left',
              width: 150
            }
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          
        }
      });


      $('#cmb_rek').combogrid({
        panelWidth: 700,
        idField: 'kd_rek6',
        textField: 'kd_rek6',
        mode: 'remote',
        url: '<?php echo base_url(); ?>index.php/Penyetoran/ambil_rek/' + kode + '/' + giat,
        columns: [
          [{
              field: 'no_terima',
              title: 'No Terima',
              width: 140
            },
            {
              field: 'kd_rek6',
              title: 'Kode Rekening',
              width: 140
            },
            {
              field: 'nm_rek',
              title: 'Uraian',
              width: 700
            },
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          $("#nmrek").attr("value", rowData.nm_rek);
          $("#nilai").attr("value", rowData.nilai);
          $("#no_terima").attr("value", rowData.no_terima);
        }
      });


      $('#giat').combogrid({
        panelWidth: 700,
        idField: 'kd_sub_kegiatan',
        textField: 'kd_sub_kegiatan',
        mode: 'remote',
        //url:'<?php echo base_url(); ?>index.php/tukd/load_trskpd1/'+lckode+'/'+lcskpd,
        url: '<?php echo base_url(); ?>index.php/Penyetoran/load_trskpd_pend/' + kode,
        columns: [
          [{
              field: 'kd_sub_kegiatan',
              title: 'Kode Kegiatan',
              width: 140
            },
            {
              field: 'nm_sub_kegiatan',
              title: 'Nama Kegiatan',
              width: 700
            }
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          giat = rowData.kd_sub_kegiatan;
          $("#nmgiat").attr("value", rowData.nm_sub_kegiatan);
        }

      });

      $('#kd_bank').combogrid({
        panelWidth: 700,
        url: '<?php echo base_url(); ?>/index.php/spp/config_bank2',
        idField: 'kd_bank',
        textField: 'kd_bank',
        mode: 'remote',
        fitColumns: true,
        columns: [
          [{
              field: 'kd_bank',
              title: 'Kd Bank',
              width: 150
            },
            {
              field: 'nama_bank',
              title: 'Nama',
              width: 500
            }
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          //$("#kode").attr("value",rowData.kode);
          // $("#nama_bank").attr("value", rowData.nama_bank);
        }
      });
      /*
      $('#pengirim').combogrid({
             panelWidth:700,  
             idField:'kd_pengirim',  
             textField:'kd_pengirim',  
             mode:'remote',
             url:'<?php echo base_url(); ?>index.php/tukd/load_pengirim',             
             columns:[[  
                 {field:'kd_pengirim',title:'Kode Pengirim',width:140},  
                 {field:'nm_pengirim',title:'Nama Pengirim',width:700}
             ]],  
             onSelect:function(rowIndex,rowData){
                 kd_pengirim = rowData.kd_pengirim;
                 $("#nmpengirim").attr("value",rowData.nm_pengirim);                                      
             }
                
          });
        */

    });

    function kunci(status) {
      // alert(status);
      if (status == 1) {
        $('#save').hide();
      } else {
        $('#save').show();
      }
    }

    function kuncinew() {

      $('#save').show();

    }


    function tglterima() {
      var tgl_trm = $('#tanggalterima').datebox('getValue');
      //alert(tgl_trm);
      $('#noterima').combogrid({

        url: '<?php echo base_url(); ?>index.php/Penyetoran/list_no_terima/' + tgl_trm,
        panelWidth: 800,
        idField: 'no_terima',
        textField: 'no_terima',
        mode: 'remote',
        fitColumns: true,
        columns: [
          [{
              field: 'no_terima',
              title: 'No Terima',
              width: 230
            },
            {
              field: 'kd_rek6',
              title: 'Kode Rekening',
              width: 100
            },
            {
              field: 'nilai',
              title: 'Total',
              align: 'left',
              width: 70
            },
            {
              field: 'nm_pengirim',
              title: 'Lokasi',
              align: 'left',
              width: 150
            }
          ]
        ],
        onSelect: function(rowIndex, rowData) {
          no_terima = rowData.no_terima;
          tgl_terima = rowData.tgl_terima;
          kd_rek6 = rowData.kd_rek6;
          kd_skpd = rowData.kd_skpd;
          nilai = rowData.nilai;
          sumber = rowData.sumber;
          nmsumber = rowData.nm_pengirim;
          var nilai1 = angka(nilai);
          var lstotal = angka(document.getElementById('jumlahtotal').value);

          total = number_format(lstotal + nilai1, 2, '.', ',');

          tampil_no_terima(no_terima, tgl_terima, kd_rek6, kd_skpd, nilai, sumber, nmsumber);

        }
      });
    }

    function tampil_no_terima(no_terima, tgl_terima, kd_rek6, kd_skpd, nilai, sumber, nmsumber) {



      $('#dg1').datagrid('selectAll');
      var rows = $('#dg1').datagrid('getSelections');
      for (var p = 0; p < rows.length; p++) {
        cno_terima = rows[p].no_terima;
        if (cno_terima == no_terima) {
          alert('Nomor ini sudah ada di LIST');
          exit();
        }
      }
      $('#dg1').datagrid('selectAll');
      jgrid = rows.length;
      pidx = jgrid + 1;
      $('#dg1').edatagrid('appendRow', {
        no_terima: no_terima,
        tgl_terima: tgl_terima,
        kd_rek6: kd_rek6,
        nilai: nilai,
        idx: pidx,
        sumber: sumber,
        nm_pengirim: nmsumber
      });
      $('#dg1').edatagrid('unselectAll');
      $('#jumlahtotal').attr('value', total);

    }

    function get_skpd() {
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/rka/config_skpd',
        type: "POST",
        dataType: "json",
        success: function(data) {
          $("#skpd").attr("value", data.kd_skpd);
          $("#nmskpd").attr("value", data.nm_skpd);
          kode = data.kd_skpd;
          lckode = '4';
          get_rek(kode);
          $('#giat').combogrid({
            url: '<?php echo base_url(); ?>index.php/Penyetoran/load_trskpd1_pend/' + lckode + '/' + kode
          });
        }
      });
    }

    function get_tahun() {
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/config_tahun',
        type: "POST",
        dataType: "json",
        success: function(data) {
          tahun_anggaran = data;
        }
      });

    }


    function get_rek(kode) {
      $('#rek').combogrid({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/ambil_rek_t_sts/' + kode
      });
    }

    function openWindow(url) {
      var no = nomor.split("/").join("BIGBOS");
      window.open(url + '/' + no, '_blank');
      window.focus();
    }

    function loadgiat() {
      var lcjnsrek = document.getElementById("jns_trans").value;
      alert(lcjnsrek);
      $('#giat').combogrid({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/load_trskpd1_pend/' + lcjnsrek
      });
    }

    function load_detail(kk) {

      $(document).ready(function() {
        $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>/index.php/Penyetoran/load_dsts',
          data: ({
            no: kk
          }),
          dataType: "json",
          success: function(data) {
            $.each(data, function(i, n) {
              id = n['id'];
              kdrek = n['kd_rek6'];
              lnrp = n['rupiah'];
              lcnmrek = n['nm_rek'];
              lcnosts = n['no_sts'];
              csumber = n['sumber'];
              cnamapengirim = n['nm_pengirim'];
              lcnoterima = n['no_terima'];
              $('#dg1').datagrid('appendRow', {
                id: id,
                no_sts: lcnosts,
                no_terima: lcnoterima,
                kd_rek6: kdrek,
                nilai: lnrp,
                nm_rek: lcnmrek,
                sumber: csumber,
                nm_pengirim: cnamapengirim
              });

            });

          }
        });
      });

      set_grid();

    }

    function section1() {
      $(document).ready(function() {
        $('#section1').click();
        $('#dg').edatagrid('reload');
      });
    }

    function section2() {
      $(document).ready(function() {
        $('#section2').click();
      });
      set_grid();
    }


    function get(nomor, tgl, kode, lckdbank, lckdgiat, lcket, lcjnskeg, lcrekbank, lctotal, jenis_status, lno_terima, spj, lno_cek, status) {

      $("#nomor").attr("value", nomor);
      $("#cmb_sts").attr("value", nomor);
      $("#cek").attr("value", lno_cek);
      $("#nomor_hide").attr("value", nomor);
      $("#tanggal").datebox("setValue", tgl);
      //$("#pengirim").combogrid("setValue",jenis_status);
      $("#ket").attr("value", lcket);
      $("#kd_bank").combogrid("setValue", lckdbank);
      $("#rek_bank").attr("value", lcrekbank);
      $('#giat').combogrid({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/load_trskpd1_pend/4/' + kode
      });
      $("#giat").combogrid("setValue", lckdgiat);
      $("#jumlahtotal").attr("value", lctotal);
      if (spj == 1) {
        $('#save').linkbutton('disable');
        $('#delete').linkbutton('disable');
        $('#tanggal').datebox('disable');
        document.getElementById("pesan").innerHTML = "Tangal Periode ini sudah Di SPJ-kan";
        document.getElementById("pesan").style.color = "Green";
      } else {
        $('#save').linkbutton('enable');
        $('#delete').linkbutton('enable');
        $('#tanggal').datebox('enable');
        document.getElementById("pesan").innerHTML = "";
      }
      kunci(status);
    }

    function get_edt(lcrekedt, lcnmrekedt, lcnilaiedt) {
      $("#rek_edt").attr("value", lcrekedt);
      $("#nmrek_edt").attr("value", lcnmrekedt);
      $("#nilai_edt").attr("value", lcnilaiedt);
      $("#nilai_edth").attr("value", lcnilaiedt);
      $("#dialog-modal_edit").dialog('open');
    }


    function kosong() {
      lcstatus = 'tambah';
      $("#nomor").attr("value", '');
      $("#no_kas").attr("value", '');
      $("#nomor_hide").attr("value", '');
      $('#noterima').combogrid('setValue', '');
      $("#tanggal").datebox("setValue", '');
      $("#tanggalkas").datebox("setValue", '');
      $("#tanggalterima").datebox("setValue", '');
      //$("#jns_trans").combobox("setValue",'');
      //$("#bank").combogrid("setValue",'');
      $("#ket").attr("value", '');
      $("#nmgiat").attr("value", '');
      $("#jumlahtotal").attr("value", 0);
      var kode = '';
      var nomor = '';
      $('#save').linkbutton('enable');
      $('#delete').linkbutton('enable');
      $('#tanggal').datebox('enable');
      document.getElementById("pesan").innerHTML = "";
      $('#giat').combogrid('setValue', '');
      kuncinew();

    }


    function cari() {
      var kriteria = document.getElementById("txtcari").value;
      $(function() {
        $('#dg').edatagrid({
          url: '<?php echo base_url(); ?>/index.php/Penyetoran/load_sts',
          queryParams: ({
            cari: kriteria
          })
        });
      });
    }


    function append_save() {

      var ckdrek = $('#cmb_rek').combogrid('getValue');
      var lcno = document.getElementById('nomor').value;
      var lcnm = document.getElementById('nmrek').value;
      var lcnl = angka(document.getElementById('nilai').value);
      var lstotal = angka(document.getElementById('jumlahtotal').value);
      var lcnl1 = number_format(lcnl, 0, '.', ',');

      if (ckdrek != '' && lcnl != 0) {
        total = number_format(lstotal + lcnl, 0, '.', ',');
        cid = cid + 1;
        $('#dg1').datagrid('appendRow', {
          id: cid,
          no_sts: lcno,
          kd_rek6: ckdrek,
          rupiah: lcnl1,
          nm_rek: lcnm
        });
        $('#jumlahtotal').attr('value', total);
        rek_filter();
      }

      $('#cmb_rek').combogrid('setValue', '');
      $('#nilai').attr('value', '0');
      $('#nmrek').attr('value', '');

    }

    function hapus_detail() {
      var lstotal = angka(document.getElementById('jumlahtotal').value);
      var rows = $('#dg1').edatagrid('getSelected');

      bno_terima = rows.no_terima;
      bnilai = rows.nilai;

      var idx = $('#dg1').edatagrid('getRowIndex', rows);
      var tny = confirm('Yakin Ingin Menghapus Data, No Terima :  ' + bno_terima + ' - Nilai :  ' + bnilai + ' ?');

      angka_nilai = angka(bnilai);

      if (tny == true) {

        hasil = number_format(lstotal - angka_nilai, 0, '.', ',');

        $('#dg1').datagrid('deleteRow', idx);
        $('#dg1').datagrid('unselectAll');
        $('#jumlahtotal').attr('value', hasil);
      }

    }

    function rek_filter() {

      var crek = '';
      $('#dg1').datagrid('selectAll');
      var rows = $('#dg1').datagrid('getSelections');
      for (var i = 0; i < rows.length; i++) {
        crek = crek + "A" + rows[i].kd_rek6 + "A";
        if (i < rows.length && i != rows.length - 1) {
          crek = crek + 'B';
        }
      }
      $('#dg1').datagrid('unselectAll');
      $('#cmb_rek').combogrid({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/ambil_rek_ag2/' + kode + '/' + giat + '/' + crek
      });
    }


    function rek_fil() {

      var crek = '';
      $('#dg1').datagrid('selectAll');
      var rows = $('#dg1').datagrid('getSelections');
      for (var i = 0; i < rows.length; i++) {
        crek = crek + "A" + rows[i].kd_rek6 + "A";
        if (i < rows.length && i != rows.length - 1) {
          crek = crek + 'B';
        }
      }
      $('#dg1').datagrid('unselectAll');
      $('#cmb_rek').combogrid({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/ambil_rek1/' + crek
      });
    }

    //data grid Detail STS
    function set_grid() {
      $('#dg1').edatagrid({
        columns: [
          [{
              field: 'id',
              title: 'ID',
              hidden: "true"
            },
            {
              field: 'no_sts',
              title: 'No STS',
              hidden: "true"
            },
            {
              field: 'no_terima',
              title: 'Nomor Terima',
              width: 2
            },
            {
              field: 'kd_rek6',
              title: 'Nomor Rekening',
              width: 2
            },
            {
              field: 'nilai',
              title: 'Rupiah',
              align: 'right',
              width: 2
            },
            {
              field: 'sumber',
              title: 'Lokasi',
              hidden: "true",
              align: 'right',
              width: 2
            },
            {
              field: 'nm_pengirim',
              title: 'Nm Lokasi',
              align: 'right',
              width: 2
            },
            {
              field: 'hapus',
              title: '',
              width: 1,
              align: "center",
              formatter: function(value, rec) {
                return '<img src="<?php echo base_url(); ?>/assets/images/icon/edit_remove.png" onclick="javascript:hapus_detail();" />';
              }
            }

          ]
        ]
      });
    }


    function tambah() {
      var lcno = document.getElementById('nomor').value;
      var cjnstetap = document.getElementById('jns_tetap').checked;
      var giat = '1';
      if (cjnstetap == true) {
        $("#dialog-modal_t").dialog('open');
      } else {

        if (lcno != '') {
          $("#dialog-modal").dialog('open');
          $('#nilai').attr('value', '0');
          $('#nmrek').attr('value', '');
          var kode = document.getElementById('skpd').value;
          var giat = $('#giat').combogrid('getValue');
        } else {
          alert('Nomor Sts Tidak Boleh kosong')
          document.getElementById('no_kas').focus();
          exit();
        }

        if (giat != '') {
          rek_filter();
        } else {
          rek_fil();
        }

      }

    }

    function cetak() {
      $("#dialog-modal_cetak").dialog('open');
    }

    function keluar() {
      $("#dialog-modal").dialog('close');
      $("#dialog-modal_t").dialog('close');
      $("#dialog-modal_cetak").dialog('close');
      $("#dialog-modal_edit").dialog('close');
    }


    function hapus_rek() {
      var lckurang = angka(lnnilai);
      var lstotal = angka(document.getElementById('jumlahtotal').value);
      lntotal = number_format(lstotal - lckurang, 0, '.', ',');

      $("#jumlahtotal").attr("value", lntotal);
      $('#dg1').datagrid('deleteRow', idx);
    }

    function hapus() {
      var cnomor = document.getElementById('nomor').value;
      var ccek = document.getElementById('cek').value;

      if (ccek == 1) {
        alert("Data Telah Divalidasi Kasda");
        exit();
      } else {
        var urll = '<?php echo base_url(); ?>index.php/Penyetoran/hapus_sts';
        var del = confirm('Anda yakin akan menghapus Nomor Penyetoran ' + cnomor + '  ?');
        if (del == true) {
          $(document).ready(function() {
            $.post(urll, ({
              no: cnomor
            }), function(data) {
              status = data;
              if (status == '0') {
                alert('Gagal Hapus..!!');
                exit();
              } else {
                alert('Data Berhasil Dihapus..!!');
                exit();
              }
            });
          });
        }
      }
    }



    function simpan_sts() {
      var cno = document.getElementById('nomor').value;
      var cno_hide = document.getElementById('nomor_hide').value;
      var no_terima = document.getElementById('noterima').value;
      var ctgl = $('#tanggal').datebox('getValue');
      var cskpd = document.getElementById('skpd').value;
      var cpengirim = '';
      var cnmskpd = document.getElementById('nmskpd').value;
      var lcket = document.getElementById('ket').value;
      var cjnsrek = '4';
      var cgiat = $('#giat').combogrid('getValue');
      // Tambahan kode bank dan rek bank
      var cbank = $('#kd_bank').combogrid('getValue');
      var lcrekbank = document.getElementById('rek_bank').value;
      // End
      // var cbank = '';
      // var lcrekbank = '';
      var lntotal = angka(document.getElementById('jumlahtotal').value);
      var cstatus = document.getElementById('jns_tetap').checked;

      var tahun_input = ctgl.substring(0, 4);


      if (tahun_input != tahun_anggaran) {
        alert('Tahun tidak sama dengan tahun Anggaran');
        exit();
      }
      if (cstatus == false) {
        cstatus = 0;
      } else {
        cstatus = 1;
      }
      if (cno == '') {
        alert('Nomor STS Tidak Boleh Kosong');
        exit();
      }
      if (ctgl == '') {
        alert('Tanggal STS Tidak Boleh Kosong');
        exit();
      }
      if (cskpd == '') {
        alert('Kode SKPD Tidak Boleh Kosong');
        exit();
      }
      if (cbank == '') {
        alert('Kode Bank Tidak Boleh Kosong');
        exit();
      }
      if (lcrekbank == '') {
        alert('Rekening Bank Tidak Boleh Kosong');
        exit();
      }

      if (lcstatus == 'tambah') {
        $(document).ready(function() {
          // alert(csql);
          $.ajax({
            type: "POST",
            dataType: 'json',
            data: ({
              no: cno,
              tabel: 'trhkasin_pkd',
              field: 'no_sts'
            }),
            url: '<?php echo base_url(); ?>/index.php/Penyetoran/cek_simpan',
            success: function(data) {
              status_cek = data.pesan;
              if (status_cek == 1) {
                alert("Nomor Telah Dipakai!");
                document.getElementById("nomor").focus();
                exit();
              }
              if (status_cek == 0) {
                alert("Nomor Bisa dipakai");
                //mulai
                $('#dg1').datagrid('selectAll');
                var rows = $('#dg1').datagrid('getSelections');
                lcval_det = '';
                for (var i = 0; i < rows.length; i++) {
                  cnoterima = rows[i].no_terima;
                  ckdrek = rows[i].kd_rek6;
                  cnilai = angka(rows[i].nilai);
                  csumber = rows[i].sumber;
                  if (i > 0) {
                    lcval_det = lcval_det + ",('" + cskpd + "','" + cno + "','" + ckdrek + "','" + cnilai + "','" + cgiat + "','" + cnoterima + "','" + csumber + "')";
                  } else {
                    lcval_det = lcval_det + "('" + cskpd + "','" + cno + "','" + ckdrek + "','" + cnilai + "','" + cgiat + "','" + cnoterima + "','" + csumber + "')";
                  }
                }
                $('#dg1').datagrid('unselectAll');

                $(document).ready(function() {
                  $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/Penyetoran/simpan_sts_pendapatan',
                    data: ({
                      tabel: 'trhkasin_pkd',
                      cid: 'no_sts',
                      lcid: cno,
                      no: cno,
                      bank: cbank,
                      tgl: ctgl,
                      skpd: cskpd,
                      pengirim: cpengirim,
                      ket: lcket,
                      jnsrek: cjnsrek,
                      giat: cgiat,
                      rekbank: lcrekbank,
                      total: lntotal,
                      value_det: lcval_det,
                      sts: cstatus,
                      no_terima: no_terima
                    }),
                    dataType: "json",
                    success: function(data) {
                      status = data;
                      if (status == '0') {
                        alert('gagal');
                        exit();
                      } else
                      if (status == '2') {
                        alert("Data Tersimpan...!!!");
                        $("#nomor_hide").attr("Value", cno);
                        lcstatus = 'edit';
                        section1();
                        //refresh();
                      }
                    }
                  });
                });
                //akhir-mulai 
              }
            }
          });
        });

      } else {
        $(document).ready(function() {
          // alert(csql);
          $.ajax({
            type: "POST",
            dataType: 'json',
            data: ({
              no: cno,
              tabel: 'trhkasin_pkd',
              field: 'no_sts'
            }),
            url: '<?php echo base_url(); ?>/index.php/Penyetoran/cek_simpan',
            success: function(data) {
              status_cek = data.pesan;
              if (status_cek == 1 && cno != cno_hide) {
                alert("Nomor Telah Dipakai!");
                exit();
              }
              if (status_cek == 0 || cno == cno_hide) {
                alert("Nomor Bisa dipakai");
                //mulai     

                $('#dg1').datagrid('selectAll');
                var rows = $('#dg1').datagrid('getSelections');
                lcval_det = '';
                for (var i = 0; i < rows.length; i++) {
                  cnoterima = rows[i].no_terima;
                  ckdrek = rows[i].kd_rek6;
                  cnilai = angka(rows[i].nilai);
                  if (i > 0) {
                    lcval_det = lcval_det + ",('" + cskpd + "','" + cno + "','" + ckdrek + "','" + cnilai + "','" + cgiat + "','" + cnoterima + "','" + csumber + "')";
                  } else {
                    lcval_det = lcval_det + "('" + cskpd + "','" + cno + "','" + ckdrek + "','" + cnilai + "','" + cgiat + "','" + cnoterima + "','" + csumber + "')";
                  }
                }
                $('#dg1').datagrid('unselectAll');
                $(document).ready(function() {
                  $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>/index.php/Penyetoran/update_sts_pendapatan_ag',
                    data: ({
                      tabel: 'trhkasin_pkd',
                      cid: 'no_sts',
                      lcid: cno,
                      no: cno,
                      bank: cbank,
                      tgl: ctgl,
                      skpd: cskpd,
                      pengirim: cpengirim,
                      ket: lcket,
                      jnsrek: cjnsrek,
                      giat: cgiat,
                      rekbank: lcrekbank,
                      total: lntotal,
                      value_det: lcval_det,
                      sts: cstatus,
                      no_terima: no_terima,
                      nohide: cno_hide
                    }),
                    dataType: "json",
                    success: function(data) {

                      status = data;
                      if (status == '0') {
                        alert('gagal');
                        exit();
                      } else
                      if (status == '2') {
                        alert("Data Tersimpan...!!!");
                        $("#nomor_hide").attr("Value", cno);
                        lcstatus = 'edit';
                        // section1();
                        //refresh();
                      }

                    }
                  });
                });
                //akhir
              }
            }
          });
        });
      }

    }





    function jumlah() {

      var lcno = document.getElementById('nomor').value;
      var lcnm = document.getElementById('nmrek1').value;
      ckdrek = $('#rek').combogrid('getValue');
      var rows = $('#dg_tetap').datagrid('getChecked');
      cid = cid + 1;

      var lstotal = angka(document.getElementById('jumlahtotal').value);


      var lnjm = 0;
      for (var i = 0; i < rows.length; i++) {
        ltmb = angka(rows[i].nilai);
        lnjm = lnjm + ltmb;
      }

      total = number_format(lstotal + lnjm, 0, '.', ',');
      $('#jumlahtotal').attr('value', total);
      lcjm = number_format(lnjm, 0, '.', ',')

      $('#dg1').datagrid('appendRow', {
        id: cid,
        no_sts: lcno,
        kd_rek6: ckdrek,
        rupiah: lcjm,
        nm_rek: lcnm
      });

      keluar();
    }


    function delCommas(nStr) {
      var no = nStr.split(",").join("");
      return no1 = eval(no);
    }

    function cek() {
      var dcetak = $('#tglvalid1').datebox('getValue');
      var dcetak2 = $('#tglvalid2').datebox('getValue');
      var cskpd = document.getElementById('skpd').value;

      var url = "<?php echo site_url(); ?>/Penyetoran/ctk_str";
      window.open(url + '/' + dcetak + '/' + dcetak2 + '/' + cskpd, '_blank');
      window.focus();
    }

    function edit_detail() {

      var lnnilai = angka(document.getElementById('nilai_edt').value);
      var lnnilai_sb = angka(document.getElementById('nilai_edth').value);
      var lstotal = angka(document.getElementById('jumlahtotal').value);

      lcnilai = number_format(lnnilai, 0, '.', ',');
      total = lstotal - lnnilai_sb + lnnilai;
      ftotal = number_format(total, 0, '.', ',');
      $('#dg1').datagrid('updateRow', {
        index: idx,
        row: {
          rupiah: lcnilai
        }
      });
      $('#jumlahtotal').attr('value', ftotal);
      keluar();
    }

    function input_nomor() {
      var no_awal = document.getElementById('no_kas').value;
      $("#nomor").attr("value", no_awal);
    }

    function refresh() {
      window.location.reload();
    }

    function cek_status_spj() {
      var tgl_cek = $('#tanggal').datebox('getValue');
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/Penyetoran/cek_status_spj_terima',
        data: ({
          tgl_cek: tgl_cek
        }),
        type: "POST",
        dataType: "json",
        success: function(data) {
          status_spj = data.status_spj;
          if (status_spj == 1) {
            $('#save').linkbutton('disable');
            $('#delete').linkbutton('disable');
            swal("Error", "SPJ sudah disahkan pada bulan ini", "warning");
            document.getElementById("pesan").innerHTML = "Tangal Periode ini sudah Di SPJ-kan";
            document.getElementById("pesan").style.color = "Green";
          } else {
            $('#save').linkbutton('enable');
            $('#delete').linkbutton('enable');
            document.getElementById("pesan").innerHTML = "";
          }
        }
      });
    }

    function validasibp() {
      var cskpd = document.getElementById('skpd').value;

      $.ajax({
        type: "POST",
        dataType: 'json',
        data: ({
          cskpd: cskpd
        }),
        url: '<?php echo base_url(); ?>/index.php/Penyetoran/cek_skpdsamsat',
        success: function(data) {
          status_cek = data.pesan;
          if (status_cek == 0) {
            swal("Cancel", "Hanya Untuk UPPD BKAD", "warning");
            return;
          } else {
            var tglvalid1 = $('#tglvalid1').datebox('getValue');
            var tglvalid2 = $('#tglvalid2').datebox('getValue');

            if (tglvalid2 < tglvalid1) {
              swal("Error", "Tgl kedua tidak lebih kecil dari tanggal pertama", "warning");
              return;
            }



            var tny = confirm('Tgl STS ' + tglvalid1 + ' s/d ' + tglvalid2 + ' akan dikirim ke Kasda, Apakah Anda yakin ?');

            if (tny == true) {
              $.ajax({
                url: '<?php echo base_url(); ?>index.php/csts/validasi_sts_bp',
                data: ({
                  tglvalid1: tglvalid1,
                  tglvalid2: tglvalid2,
                  cskpd: cskpd
                }),
                type: "POST",
                dataType: "json",
                success: function(data) {
                  status = data.pesan;
                  if (status == '1') {
                    swal("Berhasil", "Data Berhasil divalidasi", "success");
                  } else {
                    swal("Error", "Data Gagal divalidasi", "warning");
                  }
                }
              });
            } else {
              swal("Cancel", "Silakan Cek Kembali", "warning");
            }
          }
        }
      });

    }
  </script>
</head>

<body>


  <div id="content">
    <div id="accordion">
      <h3><a href="#" id="section1">List STS</a></h3>
      <!--    
    <div>
    
      
    <p align="right">         
       
       <input type="text" id="tglvalid1" style="width: 140px;" />
       <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="">Validasi ke Kasda</a>
       
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>               
        <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
        <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>//->
        <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
        <input type="text" value="" id="txtcari"/>
        <table id="dg" title="List STS" style="width:870px;height:450px;" >  
        </table>
    </p> 
    </div>   
-->
      <div>
        <table>
          <tr>
            <!-- <td align="left"> -->
            <!-- <input type="text" id="tglvalid1" style="width: 100px;" /> s/d <input type="text" id="tglvalid2" style="width: 100px;" /> -->
            <!-- <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cek();">Cek</a> -->
            <!-- <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:validasibp();">Validasi</a> *) Khusus UPPD BKAD -->
            <!-- </td> -->
            <td align="right">
              <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Tambah</a>
              <!--<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
          <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>-->
              <a class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="javascript:cari();">Cari</a>
              <input type="text" value="" id="txtcari" />
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table id="dg" title="List STS" style="width:870px;height:450px;">
              </table>
            </td>
          </tr>
        </table>
      </div>

      <h3><a href="#" id="section2" onclick="javascript:set_grid();">Surat Tanda Setoran</a></h3>

      <div style="height: 350px;">
        <p id="pesan" style="font-size: large;"></p>
        <table align="center" style="width:100%;" border="0">
          <!--<tr>
                <td>No. KAS</td>
                <td><input type="text" id="no_kas" onkeyup="javascript:input_nomor();" style="width: 200px;"/><input type="hidden" id="nomor_hide" style="width: 200px;"/></td>
                <td>Tanggal KAS</td>
                <td><input type="text" id="tanggalkas" style="width: 140px;" /></td>     
            </tr>-->

          <tr>
            <td>No. S T S</td>
            <td><input type="text" id="nomor" style="width: 200px;" placeholder="Isi sama dengan No Kas" /><input type="hidden" id="nomor_hide" style="width: 200px;" /></td>
            <td>Tanggal STS</td>
            <td><input type="text" id="tanggal" style="width: 140px;" /></td>

          </tr>
          <!--<tr>
                <td>BANK</td>
                <td><input type="text" id="bank" name="bank" style="border:0;width: 150px;" readonly="true" /></td> 
                <td>Rekening Bank</td>
                <td><input type="text" id="rek_bank" style="width: 300px;"/></td>
            </tr>-->
          <tr>
            <td>S K P D</td>
            <td><input id="skpd" name="skpd" style="width: 140px;" readonly /></td>
            <td colspan="2" align="left"><input type="text" id="nmskpd" style="border:0;width: 450px;" readonly /></td>

          </tr>
          <!--
             <tr>
                
                <td>Pengirim</td>
                <td><input id="pengirim" name="pengirim" style="width: 140px;" /></td>
                <td colspan="2" align="left"><input type="text" id="nmpengirim" style="border:0;width: 450px;" readonly="true"/></td>
               
            </tr>
              -->
          <tr>
            <td>Uraian</td>
            <td colspan="2"><textarea name="ket" id="ket" cols="40" rows="1" style="border: 0;"></textarea></td>
            <td><input type="text" id="cek" style="border:0;width: 450px;" readonly="true" hidden /></td>
          </tr>
          <!--<tr>
                <td>Jenis Transaksi</td>
                <td colspan="3">
                <input  id="jns_trans" name="jns_trans" style="border:0;width: 150px;"/>                 
                </td> 
            </tr>-->
          <tr>
            <td>Kegiatan</td>
            <td><input id="giat" name="giat" style="width: 200px;" /></td>
            <td colspan="2"><input type="text" id="nmgiat" style="border:0;width: 450px;" readonly="true" /></td>
          </tr>
          <tr>
            <!-- <td colspan="4">Dengan Penetapan --><input id="jns_tetap" hidden type="checkbox" /></td>
          </tr>
          <!--<tr>
            <td>No Penerimaan</td>
            <td colspan="2"><input type="text" id="no_terima" style="border:0;width: 200px;" readonly="true"/></td></tr>-->
          <tr>
            <td>Tanggal Terima</td>
            <td><input type="text" id="tanggalterima" style="width: 140px;" /></td>
            <td>Kode Bank</td>
            <td><input type="text" id="kd_bank" style="width: 140px;" /></td>

          </tr>
          <tr style="border-bottom-style:hidden;border-spacing:0px;padding:3px 3px 3px 3px;border-collapse:collapse;">
            <td width='20%'>No Terima</td>
            <td width="80%">&nbsp;<input id="noterima" name="noterima" style="width:200px" /></td>
            <td width='20%'>Rekening Bank</td>
            <td width="80%">&nbsp;<input id="rek_bank" name="rek_bank" value="4501002886" readonly style="width:100px" /></td>
          </tr>
          <tr>
            <td colspan="4" align="right">
              <!-- <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:section2();kosong();">Baru</a>                -->
              <a id="save" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:simpan_sts();">Simpan</a>
              <a id="delete" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus();section1();">Hapus</a>
              <a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:cetak();">Cetak</a>
              <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:section1();">Kembali</a>
            </td>

          </tr>
        </table>
        <table id="dg1" title="Detail STS" style="width:870px;height:350px;">
        </table>
        <!--<div id="toolbar">
        <a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:tambah();">Tambah Rekening</a>
        <a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:hapus_rek();">Hapus Rekening</a>        
        </div>-->


        </p>
        <table border="0" align="right" style="width:100%;">
          <tr>
            <td style="width:75%;" align="right"><B>JUMLAH</B></td>
            <td align="right"><input type="text" id="jumlahtotal" readonly="true" style="border:0;width:200px;text-align:right;" /></td>
          </tr>
        </table>

      </div>
    </div>
  </div>


  <div id="dialog-modal" title="Input Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p>
    <fieldset>
      <table>
        <tr>
          <td width="110px">Kode Rekening:</td>
          <td><input id="cmb_rek" name="cmb_rek" style="width: 200px;" /></td>
        </tr>
        <tr>
          <td width="110px">Nama Rekening:</td>
          <td><input type="text" id="nmrek" readonly="true" style="border:0;width: 400px;" /></td>
        </tr>
        <tr>
          <td width="110px">Nilai:</td>
          <td><input type="text" id="nilai" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))" /></td>
        </tr>
      </table>
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:append_save();">Simpan</a>
    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>
  </div>

  <div id="dialog-modal_edit" title="Edit Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p>
    <fieldset>
      <table>
        <tr>
          <td width="110px">Kode Rekening:</td>
          <td><input type="text" id="rek_edt" readonly="true" style="width: 200px;" /></td>
        </tr>
        <tr>
          <td width="110px">Nama Rekening:</td>
          <td><input type="text" id="nmrek_edt" readonly="true" style="border:0;width: 400px;" /></td>
        </tr>
        <tr>
          <td width="110px">Nilai:</td>
          <td><input type="text" id="nilai_edt" style="text-align: right;" onkeypress="return(currencyFormat(this,',','.',event))" />
            <input type="hidden" id="nilai_edth" />
          </td>
        </tr>
      </table>
    </fieldset>
    <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:edit_detail();">Simpan</a>
    <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>
  </div>


  <div id="dialog-modal_cetak" title="Input Rekening">
    <p class="validateTips">Semua Inputan Harus Di Isi.</p>
    <fieldset>
      <table>
        <tr>
          <td width="110px">No STS:</td>
          <td><input id="cmb_sts" name="cmb_sts" style="width: 200px;background-color:#d1d1d1;" readonly/></td>
        </tr>
      </table>
    </fieldset>
    <fieldset>
      <table border="0">
        <tr align="center">
          <td></td>
          <td width="100%" align="center"><a href="<?php echo site_url(); ?>tukd/cetak_sts" class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="javascript:openWindow(this.href);return false">Cetak</a>
            <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>
          </td>
        </tr>
      </table>
    </fieldset>


  </div>


  <div id="dialog-modal_t" title="Checkbox Select">
    <table border="0">
      <tr>
        <td>Rekening</td>
        <td><input id="rek" name="rek" style="width: 140px;" /> <input type="text" id="nmrek1" style="border:0;width: 400px;" readonly="true" /></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
          <table id="dg_tetap" style="width:770px;height:350px;">
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <a class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:jumlah();">Simpan</a>
          <a class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:keluar();">Keluar</a>
        </td>
      </tr>
    </table>
  </div>

</body>

</html>