@include('header')

<link rel="stylesheet" href="{{ asset('public/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/stylesheet/stylesheet.css')}}">
<script type="text/javascript">
    if ( !$.curCSS ) {
        $.curCSS = $.css;
    }
  //-----------------------------------------
  // Confirm Actions (delete, uninstall)
  //-----------------------------------------
  $(document).ready(function(){
      // Confirm Delete
      $('#form').submit(function(){
          if ($(this).attr('action').indexOf('delete',1) != -1) {
              if (!confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?')) {
                  return false;
              }
          }
      });
      // Confirm Uninstall
      $('a').click(function(){
          if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
              if (!confirm('Delete/Uninstall cannot be undone! Are you sure you want to do this?')) {
                  return false;
              }
          }
      });
          });
      </script>
      <script type="text/javascript">
          function updateswitch()
          {
              $('input.on_switch').lc_switch("on", "off");
              $('input.en_switch').lc_switch("Enable", "Disable");
          }
          $(document).ready(function(e) {
               updateswitch();
          });
      </script>
{{-- Section of List Bulk Category --}}
<section>
    <div class="content-wrapper">
        {{-- Header Section --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bulk Categories</h1>
                    </div>
                    {{-- Breadcrumb Start --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bulk Categories </li>
                        </ol>
                    </div>
                    {{-- End Breadcumb --}}
                </div>
            </div>
        </section>
        {{-- End Header Section --}}

        {{-- List Section Start --}}
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        {{-- Card Start --}}
                        <div class="card card-primary text-center">
                        
                        
                        <body class="width_fluid">
                            <div id="ohsnap"></div>
                            <div id="skinload">
                                <div class="spinner"></div>
                            </div>
                            <div class="se-pre-con" style="display: none;">Please wait...</div>
                            <script type="text/javascript">
                                $(window).load(function() {
                                    $(".se-pre-con").fadeOut("slow");;
                                });
                            </script>
                            <div id="container" class="container">
                        
                                <div id="content">
                                    <div class="breadcrumb">
                                        <a href="#">Home</a> :: <a href="#">Category</a>
                                    </div>
                                    <div class="box">
                        
                                        <div class="content ybc-content">
                        
                                            <form method="post" enctype="multipart/form-data" id="form">
                        
                                                <select name="storeid" style="display: none;" id="selectstore">
                                        <option value="0">Default</option>
                                                        <option value="58">BLANK STORE 1</option>
                                                        <option value="18">YUMMY KEBAB PIZZA BURGER CORSHAM</option>
                                                </select>
                                                <table class="list">
                                                    <thead>
                                                        <tr>
                                                            <td style="width: 100px;height: 30px;">Name<span class="required">*</span></td>
                                                            <td style="width: 225px;">Description</td>
                                                            <td style="width: 100px;">Image</td>
                                                            <td>Options</td>
                                                            <td style="width: 50px;">Active</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="bulkcat">
                        
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_0').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_0').show();
                                                                } else {
                                                                    $('#base_size_0').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_0').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_0').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_0').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_0 = 0;
                        
                                                            function addsizevalue0() {
                                                                size_value_row_0++;
                                                                html = '  <tr rel="' + size_value_row_0 + '" class="size size_' + size_value_row_0 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_0_' + size_value_row_0 + '\').html($(this).val());" name="category[0][size][' + size_value_row_0 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_0_' + size_value_row_0 + '\').html($(this).val());" name="category[0][short_order][' + size_value_row_0 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_0 + '\').remove();updatesizegroup0();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_0').append(html);
                                                                updatesizegroup0();
                        
                                                            }
                                                            var number_group_0 = 0;
                                                            var contentgroup_0 = $('#ybc_group_0').html();
                        
                                                            function addgroup0() {
                                                                number_group_0++;
                                                                html = '';
                                                                html = '<div id="group_0_' + number_group_0 + '" rel="' + number_group_0 + '" class="group_topping">' + contentgroup_0.split("number_group").join(number_group_0); + '</div>'; //
                                                                $('#add_group_0').before(html);
                                                                updatesizegroup0();
                                                            }
                        
                                                            function updatesizegroup0() {
                                                                if ($('.ybc_cat_0 #base_size_0 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_0 #size-value-row_0 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_0_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[0][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_0 #base_size_0 .group_topping').each(function() {
                                                                        $(this).find('.size_0').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_1').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_1').show();
                                                                } else {
                                                                    $('#base_size_1').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_1').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_1').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_1').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_1 = 0;
                        
                                                            function addsizevalue1() {
                                                                size_value_row_1++;
                                                                html = '  <tr rel="' + size_value_row_1 + '" class="size size_' + size_value_row_1 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_1_' + size_value_row_1 + '\').html($(this).val());" name="category[1][size][' + size_value_row_1 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_1_' + size_value_row_1 + '\').html($(this).val());" name="category[1][short_order][' + size_value_row_1 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_1 + '\').remove();updatesizegroup1();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_1').append(html);
                                                                updatesizegroup1();
                        
                                                            }
                                                            var number_group_1 = 0;
                                                            var contentgroup_1 = $('#ybc_group_1').html();
                        
                                                            function addgroup1() {
                                                                number_group_1++;
                                                                html = '';
                                                                html = '<div id="group_1_' + number_group_1 + '" rel="' + number_group_1 + '" class="group_topping">' + contentgroup_1.split("number_group").join(number_group_1); + '</div>'; //
                                                                $('#add_group_1').before(html);
                                                                updatesizegroup1();
                                                            }
                        
                                                            function updatesizegroup1() {
                                                                if ($('.ybc_cat_1 #base_size_1 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_1 #size-value-row_1 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_1_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[1][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_1 #base_size_1 .group_topping').each(function() {
                                                                        $(this).find('.size_1').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_2').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_2').show();
                                                                } else {
                                                                    $('#base_size_2').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_2').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_2').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_2').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_2 = 0;
                        
                                                            function addsizevalue2() {
                                                                size_value_row_2++;
                                                                html = '  <tr rel="' + size_value_row_2 + '" class="size size_' + size_value_row_2 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_2_' + size_value_row_2 + '\').html($(this).val());" name="category[2][size][' + size_value_row_2 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_2_' + size_value_row_2 + '\').html($(this).val());" name="category[2][short_order][' + size_value_row_2 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_2 + '\').remove();updatesizegroup2();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_2').append(html);
                                                                updatesizegroup2();
                        
                                                            }
                                                            var number_group_2 = 0;
                                                            var contentgroup_2 = $('#ybc_group_2').html();
                        
                                                            function addgroup2() {
                                                                number_group_2++;
                                                                html = '';
                                                                html = '<div id="group_2_' + number_group_2 + '" rel="' + number_group_2 + '" class="group_topping">' + contentgroup_2.split("number_group").join(number_group_2); + '</div>'; //
                                                                $('#add_group_2').before(html);
                                                                updatesizegroup2();
                                                            }
                        
                                                            function updatesizegroup2() {
                                                                if ($('.ybc_cat_2 #base_size_2 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_2 #size-value-row_2 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_2_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[2][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_2 #base_size_2 .group_topping').each(function() {
                                                                        $(this).find('.size_2').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_3').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_3').show();
                                                                } else {
                                                                    $('#base_size_3').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_3').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_3').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_3').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_3 = 0;
                        
                                                            function addsizevalue3() {
                                                                size_value_row_3++;
                                                                html = '  <tr rel="' + size_value_row_3 + '" class="size size_' + size_value_row_3 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_3_' + size_value_row_3 + '\').html($(this).val());" name="category[3][size][' + size_value_row_3 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_3_' + size_value_row_3 + '\').html($(this).val());" name="category[3][short_order][' + size_value_row_3 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_3 + '\').remove();updatesizegroup3();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_3').append(html);
                                                                updatesizegroup3();
                        
                                                            }
                                                            var number_group_3 = 0;
                                                            var contentgroup_3 = $('#ybc_group_3').html();
                        
                                                            function addgroup3() {
                                                                number_group_3++;
                                                                html = '';
                                                                html = '<div id="group_3_' + number_group_3 + '" rel="' + number_group_3 + '" class="group_topping">' + contentgroup_3.split("number_group").join(number_group_3); + '</div>'; //
                                                                $('#add_group_3').before(html);
                                                                updatesizegroup3();
                                                            }
                        
                                                            function updatesizegroup3() {
                                                                if ($('.ybc_cat_3 #base_size_3 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_3 #size-value-row_3 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_3_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[3][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_3 #base_size_3 .group_topping').each(function() {
                                                                        $(this).find('.size_3').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_4').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_4').show();
                                                                } else {
                                                                    $('#base_size_4').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_4').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_4').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_4').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_4 = 0;
                        
                                                            function addsizevalue4() {
                                                                size_value_row_4++;
                                                                html = '  <tr rel="' + size_value_row_4 + '" class="size size_' + size_value_row_4 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_4_' + size_value_row_4 + '\').html($(this).val());" name="category[4][size][' + size_value_row_4 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_4_' + size_value_row_4 + '\').html($(this).val());" name="category[4][short_order][' + size_value_row_4 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_4 + '\').remove();updatesizegroup4();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_4').append(html);
                                                                updatesizegroup4();
                        
                                                            }
                                                            var number_group_4 = 0;
                                                            var contentgroup_4 = $('#ybc_group_4').html();
                        
                                                            function addgroup4() {
                                                                number_group_4++;
                                                                html = '';
                                                                html = '<div id="group_4_' + number_group_4 + '" rel="' + number_group_4 + '" class="group_topping">' + contentgroup_4.split("number_group").join(number_group_4); + '</div>'; //
                                                                $('#add_group_4').before(html);
                                                                updatesizegroup4();
                                                            }
                        
                                                            function updatesizegroup4() {
                                                                if ($('.ybc_cat_4 #base_size_4 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_4 #size-value-row_4 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_4_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[4][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_4 #base_size_4 .group_topping').each(function() {
                                                                        $(this).find('.size_4').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_5').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_5').show();
                                                                } else {
                                                                    $('#base_size_5').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_5').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_5').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_5').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_5 = 0;
                        
                                                            function addsizevalue5() {
                                                                size_value_row_5++;
                                                                html = '  <tr rel="' + size_value_row_5 + '" class="size size_' + size_value_row_5 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_5_' + size_value_row_5 + '\').html($(this).val());" name="category[5][size][' + size_value_row_5 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_5_' + size_value_row_5 + '\').html($(this).val());" name="category[5][short_order][' + size_value_row_5 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_5 + '\').remove();updatesizegroup5();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_5').append(html);
                                                                updatesizegroup5();
                        
                                                            }
                                                            var number_group_5 = 0;
                                                            var contentgroup_5 = $('#ybc_group_5').html();
                        
                                                            function addgroup5() {
                                                                number_group_5++;
                                                                html = '';
                                                                html = '<div id="group_5_' + number_group_5 + '" rel="' + number_group_5 + '" class="group_topping">' + contentgroup_5.split("number_group").join(number_group_5); + '</div>'; //
                                                                $('#add_group_5').before(html);
                                                                updatesizegroup5();
                                                            }
                        
                                                            function updatesizegroup5() {
                                                                if ($('.ybc_cat_5 #base_size_5 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_5 #size-value-row_5 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_5_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[5][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_5 #base_size_5 .group_topping').each(function() {
                                                                        $(this).find('.size_5').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_6').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_6').show();
                                                                } else {
                                                                    $('#base_size_6').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_6').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_6').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_6').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_6 = 0;
                        
                                                            function addsizevalue6() {
                                                                size_value_row_6++;
                                                                html = '  <tr rel="' + size_value_row_6 + '" class="size size_' + size_value_row_6 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_6_' + size_value_row_6 + '\').html($(this).val());" name="category[6][size][' + size_value_row_6 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_6_' + size_value_row_6 + '\').html($(this).val());" name="category[6][short_order][' + size_value_row_6 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_6 + '\').remove();updatesizegroup6();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_6').append(html);
                                                                updatesizegroup6();
                        
                                                            }
                                                            var number_group_6 = 0;
                                                            var contentgroup_6 = $('#ybc_group_6').html();
                        
                                                            function addgroup6() {
                                                                number_group_6++;
                                                                html = '';
                                                                html = '<div id="group_6_' + number_group_6 + '" rel="' + number_group_6 + '" class="group_topping">' + contentgroup_6.split("number_group").join(number_group_6); + '</div>'; //
                                                                $('#add_group_6').before(html);
                                                                updatesizegroup6();
                                                            }
                        
                                                            function updatesizegroup6() {
                                                                if ($('.ybc_cat_6 #base_size_6 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_6 #size-value-row_6 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_6_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[6][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_6 #base_size_6 .group_topping').each(function() {
                                                                        $(this).find('.size_6').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_7').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_7').show();
                                                                } else {
                                                                    $('#base_size_7').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_7').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_7').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_7').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_7 = 0;
                        
                                                            function addsizevalue7() {
                                                                size_value_row_7++;
                                                                html = '  <tr rel="' + size_value_row_7 + '" class="size size_' + size_value_row_7 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_7_' + size_value_row_7 + '\').html($(this).val());" name="category[7][size][' + size_value_row_7 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_7_' + size_value_row_7 + '\').html($(this).val());" name="category[7][short_order][' + size_value_row_7 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_7 + '\').remove();updatesizegroup7();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_7').append(html);
                                                                updatesizegroup7();
                        
                                                            }
                                                            var number_group_7 = 0;
                                                            var contentgroup_7 = $('#ybc_group_7').html();
                        
                                                            function addgroup7() {
                                                                number_group_7++;
                                                                html = '';
                                                                html = '<div id="group_7_' + number_group_7 + '" rel="' + number_group_7 + '" class="group_topping">' + contentgroup_7.split("number_group").join(number_group_7); + '</div>'; //
                                                                $('#add_group_7').before(html);
                                                                updatesizegroup7();
                                                            }
                        
                                                            function updatesizegroup7() {
                                                                if ($('.ybc_cat_7 #base_size_7 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_7 #size-value-row_7 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_7_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[7][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_7 #base_size_7 .group_topping').each(function() {
                                                                        $(this).find('.size_7').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_8').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_8').show();
                                                                } else {
                                                                    $('#base_size_8').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_8').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_8').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_8').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_8 = 0;
                        
                                                            function addsizevalue8() {
                                                                size_value_row_8++;
                                                                html = '  <tr rel="' + size_value_row_8 + '" class="size size_' + size_value_row_8 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_8_' + size_value_row_8 + '\').html($(this).val());" name="category[8][size][' + size_value_row_8 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_8_' + size_value_row_8 + '\').html($(this).val());" name="category[8][short_order][' + size_value_row_8 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_8 + '\').remove();updatesizegroup8();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_8').append(html);
                                                                updatesizegroup8();
                        
                                                            }
                                                            var number_group_8 = 0;
                                                            var contentgroup_8 = $('#ybc_group_8').html();
                        
                                                            function addgroup8() {
                                                                number_group_8++;
                                                                html = '';
                                                                html = '<div id="group_8_' + number_group_8 + '" rel="' + number_group_8 + '" class="group_topping">' + contentgroup_8.split("number_group").join(number_group_8); + '</div>'; //
                                                                $('#add_group_8').before(html);
                                                                updatesizegroup8();
                                                            }
                        
                                                            function updatesizegroup8() {
                                                                if ($('.ybc_cat_8 #base_size_8 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_8 #size-value-row_8 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_8_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[8][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_8 #base_size_8 .group_topping').each(function() {
                                                                        $(this).find('.size_8').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_9').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_9').show();
                                                                } else {
                                                                    $('#base_size_9').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_9').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_9').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_9').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_9 = 0;
                        
                                                            function addsizevalue9() {
                                                                size_value_row_9++;
                                                                html = '  <tr rel="' + size_value_row_9 + '" class="size size_' + size_value_row_9 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_9_' + size_value_row_9 + '\').html($(this).val());" name="category[9][size][' + size_value_row_9 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_9_' + size_value_row_9 + '\').html($(this).val());" name="category[9][short_order][' + size_value_row_9 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_9 + '\').remove();updatesizegroup9();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_9').append(html);
                                                                updatesizegroup9();
                        
                                                            }
                                                            var number_group_9 = 0;
                                                            var contentgroup_9 = $('#ybc_group_9').html();
                        
                                                            function addgroup9() {
                                                                number_group_9++;
                                                                html = '';
                                                                html = '<div id="group_9_' + number_group_9 + '" rel="' + number_group_9 + '" class="group_topping">' + contentgroup_9.split("number_group").join(number_group_9); + '</div>'; //
                                                                $('#add_group_9').before(html);
                                                                updatesizegroup9();
                                                            }
                        
                                                            function updatesizegroup9() {
                                                                if ($('.ybc_cat_9 #base_size_9 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_9 #size-value-row_9 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_9_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[9][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_9 #base_size_9 .group_topping').each(function() {
                                                                        $(this).find('.size_9').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_10').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_10').show();
                                                                } else {
                                                                    $('#base_size_10').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_10').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_10').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_10').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_10 = 0;
                        
                                                            function addsizevalue10() {
                                                                size_value_row_10++;
                                                                html = '  <tr rel="' + size_value_row_10 + '" class="size size_' + size_value_row_10 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_10_' + size_value_row_10 + '\').html($(this).val());" name="category[10][size][' + size_value_row_10 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_10_' + size_value_row_10 + '\').html($(this).val());" name="category[10][short_order][' + size_value_row_10 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_10 + '\').remove();updatesizegroup10();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_10').append(html);
                                                                updatesizegroup10();
                        
                                                            }
                                                            var number_group_10 = 0;
                                                            var contentgroup_10 = $('#ybc_group_10').html();
                        
                                                            function addgroup10() {
                                                                number_group_10++;
                                                                html = '';
                                                                html = '<div id="group_10_' + number_group_10 + '" rel="' + number_group_10 + '" class="group_topping">' + contentgroup_10.split("number_group").join(number_group_10); + '</div>'; //
                                                                $('#add_group_10').before(html);
                                                                updatesizegroup10();
                                                            }
                        
                                                            function updatesizegroup10() {
                                                                if ($('.ybc_cat_10 #base_size_10 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_10 #size-value-row_10 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_10_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[10][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_10 #base_size_10 .group_topping').each(function() {
                                                                        $(this).find('.size_10').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_11').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_11').show();
                                                                } else {
                                                                    $('#base_size_11').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_11').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_11').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_11').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_11 = 0;
                        
                                                            function addsizevalue11() {
                                                                size_value_row_11++;
                                                                html = '  <tr rel="' + size_value_row_11 + '" class="size size_' + size_value_row_11 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_11_' + size_value_row_11 + '\').html($(this).val());" name="category[11][size][' + size_value_row_11 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_11_' + size_value_row_11 + '\').html($(this).val());" name="category[11][short_order][' + size_value_row_11 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_11 + '\').remove();updatesizegroup11();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_11').append(html);
                                                                updatesizegroup11();
                        
                                                            }
                                                            var number_group_11 = 0;
                                                            var contentgroup_11 = $('#ybc_group_11').html();
                        
                                                            function addgroup11() {
                                                                number_group_11++;
                                                                html = '';
                                                                html = '<div id="group_11_' + number_group_11 + '" rel="' + number_group_11 + '" class="group_topping">' + contentgroup_11.split("number_group").join(number_group_11); + '</div>'; //
                                                                $('#add_group_11').before(html);
                                                                updatesizegroup11();
                                                            }
                        
                                                            function updatesizegroup11() {
                                                                if ($('.ybc_cat_11 #base_size_11 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_11 #size-value-row_11 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_11_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[11][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_11 #base_size_11 .group_topping').each(function() {
                                                                        $(this).find('.size_11').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_12').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_12').show();
                                                                } else {
                                                                    $('#base_size_12').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_12').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_12').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_12').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_12 = 0;
                        
                                                            function addsizevalue12() {
                                                                size_value_row_12++;
                                                                html = '  <tr rel="' + size_value_row_12 + '" class="size size_' + size_value_row_12 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_12_' + size_value_row_12 + '\').html($(this).val());" name="category[12][size][' + size_value_row_12 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_12_' + size_value_row_12 + '\').html($(this).val());" name="category[12][short_order][' + size_value_row_12 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_12 + '\').remove();updatesizegroup12();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_12').append(html);
                                                                updatesizegroup12();
                        
                                                            }
                                                            var number_group_12 = 0;
                                                            var contentgroup_12 = $('#ybc_group_12').html();
                        
                                                            function addgroup12() {
                                                                number_group_12++;
                                                                html = '';
                                                                html = '<div id="group_12_' + number_group_12 + '" rel="' + number_group_12 + '" class="group_topping">' + contentgroup_12.split("number_group").join(number_group_12); + '</div>'; //
                                                                $('#add_group_12').before(html);
                                                                updatesizegroup12();
                                                            }
                        
                                                            function updatesizegroup12() {
                                                                if ($('.ybc_cat_12 #base_size_12 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_12 #size-value-row_12 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_12_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[12][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_12 #base_size_12 .group_topping').each(function() {
                                                                        $(this).find('.size_12').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_13').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_13').show();
                                                                } else {
                                                                    $('#base_size_13').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_13').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_13').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_13').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_13 = 0;
                        
                                                            function addsizevalue13() {
                                                                size_value_row_13++;
                                                                html = '  <tr rel="' + size_value_row_13 + '" class="size size_' + size_value_row_13 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_13_' + size_value_row_13 + '\').html($(this).val());" name="category[13][size][' + size_value_row_13 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_13_' + size_value_row_13 + '\').html($(this).val());" name="category[13][short_order][' + size_value_row_13 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_13 + '\').remove();updatesizegroup13();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_13').append(html);
                                                                updatesizegroup13();
                        
                                                            }
                                                            var number_group_13 = 0;
                                                            var contentgroup_13 = $('#ybc_group_13').html();
                        
                                                            function addgroup13() {
                                                                number_group_13++;
                                                                html = '';
                                                                html = '<div id="group_13_' + number_group_13 + '" rel="' + number_group_13 + '" class="group_topping">' + contentgroup_13.split("number_group").join(number_group_13); + '</div>'; //
                                                                $('#add_group_13').before(html);
                                                                updatesizegroup13();
                                                            }
                        
                                                            function updatesizegroup13() {
                                                                if ($('.ybc_cat_13 #base_size_13 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_13 #size-value-row_13 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_13_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[13][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_13 #base_size_13 .group_topping').each(function() {
                                                                        $(this).find('.size_13').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_14').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_14').show();
                                                                } else {
                                                                    $('#base_size_14').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_14').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_14').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_14').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_14 = 0;
                        
                                                            function addsizevalue14() {
                                                                size_value_row_14++;
                                                                html = '  <tr rel="' + size_value_row_14 + '" class="size size_' + size_value_row_14 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_14_' + size_value_row_14 + '\').html($(this).val());" name="category[14][size][' + size_value_row_14 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_14_' + size_value_row_14 + '\').html($(this).val());" name="category[14][short_order][' + size_value_row_14 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_14 + '\').remove();updatesizegroup14();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_14').append(html);
                                                                updatesizegroup14();
                        
                                                            }
                                                            var number_group_14 = 0;
                                                            var contentgroup_14 = $('#ybc_group_14').html();
                        
                                                            function addgroup14() {
                                                                number_group_14++;
                                                                html = '';
                                                                html = '<div id="group_14_' + number_group_14 + '" rel="' + number_group_14 + '" class="group_topping">' + contentgroup_14.split("number_group").join(number_group_14); + '</div>'; //
                                                                $('#add_group_14').before(html);
                                                                updatesizegroup14();
                                                            }
                        
                                                            function updatesizegroup14() {
                                                                if ($('.ybc_cat_14 #base_size_14 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_14 #size-value-row_14 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_14_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[14][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_14 #base_size_14 .group_topping').each(function() {
                                                                        $(this).find('.size_14').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_15').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_15').show();
                                                                } else {
                                                                    $('#base_size_15').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_15').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_15').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_15').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_15 = 0;
                        
                                                            function addsizevalue15() {
                                                                size_value_row_15++;
                                                                html = '  <tr rel="' + size_value_row_15 + '" class="size size_' + size_value_row_15 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_15_' + size_value_row_15 + '\').html($(this).val());" name="category[15][size][' + size_value_row_15 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_15_' + size_value_row_15 + '\').html($(this).val());" name="category[15][short_order][' + size_value_row_15 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_15 + '\').remove();updatesizegroup15();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_15').append(html);
                                                                updatesizegroup15();
                        
                                                            }
                                                            var number_group_15 = 0;
                                                            var contentgroup_15 = $('#ybc_group_15').html();
                        
                                                            function addgroup15() {
                                                                number_group_15++;
                                                                html = '';
                                                                html = '<div id="group_15_' + number_group_15 + '" rel="' + number_group_15 + '" class="group_topping">' + contentgroup_15.split("number_group").join(number_group_15); + '</div>'; //
                                                                $('#add_group_15').before(html);
                                                                updatesizegroup15();
                                                            }
                        
                                                            function updatesizegroup15() {
                                                                if ($('.ybc_cat_15 #base_size_15 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_15 #size-value-row_15 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_15_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[15][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_15 #base_size_15 .group_topping').each(function() {
                                                                        $(this).find('.size_15').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_16').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_16').show();
                                                                } else {
                                                                    $('#base_size_16').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_16').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_16').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_16').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_16 = 0;
                        
                                                            function addsizevalue16() {
                                                                size_value_row_16++;
                                                                html = '  <tr rel="' + size_value_row_16 + '" class="size size_' + size_value_row_16 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_16_' + size_value_row_16 + '\').html($(this).val());" name="category[16][size][' + size_value_row_16 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_16_' + size_value_row_16 + '\').html($(this).val());" name="category[16][short_order][' + size_value_row_16 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_16 + '\').remove();updatesizegroup16();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_16').append(html);
                                                                updatesizegroup16();
                        
                                                            }
                                                            var number_group_16 = 0;
                                                            var contentgroup_16 = $('#ybc_group_16').html();
                        
                                                            function addgroup16() {
                                                                number_group_16++;
                                                                html = '';
                                                                html = '<div id="group_16_' + number_group_16 + '" rel="' + number_group_16 + '" class="group_topping">' + contentgroup_16.split("number_group").join(number_group_16); + '</div>'; //
                                                                $('#add_group_16').before(html);
                                                                updatesizegroup16();
                                                            }
                        
                                                            function updatesizegroup16() {
                                                                if ($('.ybc_cat_16 #base_size_16 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_16 #size-value-row_16 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_16_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[16][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_16 #base_size_16 .group_topping').each(function() {
                                                                        $(this).find('.size_16').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_17').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_17').show();
                                                                } else {
                                                                    $('#base_size_17').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_17').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_17').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_17').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_17 = 0;
                        
                                                            function addsizevalue17() {
                                                                size_value_row_17++;
                                                                html = '  <tr rel="' + size_value_row_17 + '" class="size size_' + size_value_row_17 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_17_' + size_value_row_17 + '\').html($(this).val());" name="category[17][size][' + size_value_row_17 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_17_' + size_value_row_17 + '\').html($(this).val());" name="category[17][short_order][' + size_value_row_17 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_17 + '\').remove();updatesizegroup17();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_17').append(html);
                                                                updatesizegroup17();
                        
                                                            }
                                                            var number_group_17 = 0;
                                                            var contentgroup_17 = $('#ybc_group_17').html();
                        
                                                            function addgroup17() {
                                                                number_group_17++;
                                                                html = '';
                                                                html = '<div id="group_17_' + number_group_17 + '" rel="' + number_group_17 + '" class="group_topping">' + contentgroup_17.split("number_group").join(number_group_17); + '</div>'; //
                                                                $('#add_group_17').before(html);
                                                                updatesizegroup17();
                                                            }
                        
                                                            function updatesizegroup17() {
                                                                if ($('.ybc_cat_17 #base_size_17 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_17 #size-value-row_17 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_17_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[17][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_17 #base_size_17 .group_topping').each(function() {
                                                                        $(this).find('.size_17').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_18').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_18').show();
                                                                } else {
                                                                    $('#base_size_18').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_18').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_18').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_18').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_18 = 0;
                        
                                                            function addsizevalue18() {
                                                                size_value_row_18++;
                                                                html = '  <tr rel="' + size_value_row_18 + '" class="size size_' + size_value_row_18 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_18_' + size_value_row_18 + '\').html($(this).val());" name="category[18][size][' + size_value_row_18 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_18_' + size_value_row_18 + '\').html($(this).val());" name="category[18][short_order][' + size_value_row_18 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_18 + '\').remove();updatesizegroup18();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_18').append(html);
                                                                updatesizegroup18();
                        
                                                            }
                                                            var number_group_18 = 0;
                                                            var contentgroup_18 = $('#ybc_group_18').html();
                        
                                                            function addgroup18() {
                                                                number_group_18++;
                                                                html = '';
                                                                html = '<div id="group_18_' + number_group_18 + '" rel="' + number_group_18 + '" class="group_topping">' + contentgroup_18.split("number_group").join(number_group_18); + '</div>'; //
                                                                $('#add_group_18').before(html);
                                                                updatesizegroup18();
                                                            }
                        
                                                            function updatesizegroup18() {
                                                                if ($('.ybc_cat_18 #base_size_18 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_18 #size-value-row_18 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_18_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[18][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_18 #base_size_18 .group_topping').each(function() {
                                                                        $(this).find('.size_18').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_19').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_19').show();
                                                                } else {
                                                                    $('#base_size_19').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_19').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_19').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_19').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_19 = 0;
                        
                                                            function addsizevalue19() {
                                                                size_value_row_19++;
                                                                html = '  <tr rel="' + size_value_row_19 + '" class="size size_' + size_value_row_19 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_19_' + size_value_row_19 + '\').html($(this).val());" name="category[19][size][' + size_value_row_19 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_19_' + size_value_row_19 + '\').html($(this).val());" name="category[19][short_order][' + size_value_row_19 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_19 + '\').remove();updatesizegroup19();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_19').append(html);
                                                                updatesizegroup19();
                        
                                                            }
                                                            var number_group_19 = 0;
                                                            var contentgroup_19 = $('#ybc_group_19').html();
                        
                                                            function addgroup19() {
                                                                number_group_19++;
                                                                html = '';
                                                                html = '<div id="group_19_' + number_group_19 + '" rel="' + number_group_19 + '" class="group_topping">' + contentgroup_19.split("number_group").join(number_group_19); + '</div>'; //
                                                                $('#add_group_19').before(html);
                                                                updatesizegroup19();
                                                            }
                        
                                                            function updatesizegroup19() {
                                                                if ($('.ybc_cat_19 #base_size_19 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_19 #size-value-row_19 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_19_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[19][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_19 #base_size_19 .group_topping').each(function() {
                                                                        $(this).find('.size_19').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_20').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_20').show();
                                                                } else {
                                                                    $('#base_size_20').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_20').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_20').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_20').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_20 = 0;
                        
                                                            function addsizevalue20() {
                                                                size_value_row_20++;
                                                                html = '  <tr rel="' + size_value_row_20 + '" class="size size_' + size_value_row_20 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_20_' + size_value_row_20 + '\').html($(this).val());" name="category[20][size][' + size_value_row_20 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_20_' + size_value_row_20 + '\').html($(this).val());" name="category[20][short_order][' + size_value_row_20 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_20 + '\').remove();updatesizegroup20();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_20').append(html);
                                                                updatesizegroup20();
                        
                                                            }
                                                            var number_group_20 = 0;
                                                            var contentgroup_20 = $('#ybc_group_20').html();
                        
                                                            function addgroup20() {
                                                                number_group_20++;
                                                                html = '';
                                                                html = '<div id="group_20_' + number_group_20 + '" rel="' + number_group_20 + '" class="group_topping">' + contentgroup_20.split("number_group").join(number_group_20); + '</div>'; //
                                                                $('#add_group_20').before(html);
                                                                updatesizegroup20();
                                                            }
                        
                                                            function updatesizegroup20() {
                                                                if ($('.ybc_cat_20 #base_size_20 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_20 #size-value-row_20 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_20_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[20][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_20 #base_size_20 .group_topping').each(function() {
                                                                        $(this).find('.size_20').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_21').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_21').show();
                                                                } else {
                                                                    $('#base_size_21').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_21').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_21').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_21').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_21 = 0;
                        
                                                            function addsizevalue21() {
                                                                size_value_row_21++;
                                                                html = '  <tr rel="' + size_value_row_21 + '" class="size size_' + size_value_row_21 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_21_' + size_value_row_21 + '\').html($(this).val());" name="category[21][size][' + size_value_row_21 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_21_' + size_value_row_21 + '\').html($(this).val());" name="category[21][short_order][' + size_value_row_21 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_21 + '\').remove();updatesizegroup21();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_21').append(html);
                                                                updatesizegroup21();
                        
                                                            }
                                                            var number_group_21 = 0;
                                                            var contentgroup_21 = $('#ybc_group_21').html();
                        
                                                            function addgroup21() {
                                                                number_group_21++;
                                                                html = '';
                                                                html = '<div id="group_21_' + number_group_21 + '" rel="' + number_group_21 + '" class="group_topping">' + contentgroup_21.split("number_group").join(number_group_21); + '</div>'; //
                                                                $('#add_group_21').before(html);
                                                                updatesizegroup21();
                                                            }
                        
                                                            function updatesizegroup21() {
                                                                if ($('.ybc_cat_21 #base_size_21 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_21 #size-value-row_21 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_21_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[21][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_21 #base_size_21 .group_topping').each(function() {
                                                                        $(this).find('.size_21').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_22').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_22').show();
                                                                } else {
                                                                    $('#base_size_22').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_22').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_22').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_22').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_22 = 0;
                        
                                                            function addsizevalue22() {
                                                                size_value_row_22++;
                                                                html = '  <tr rel="' + size_value_row_22 + '" class="size size_' + size_value_row_22 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_22_' + size_value_row_22 + '\').html($(this).val());" name="category[22][size][' + size_value_row_22 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_22_' + size_value_row_22 + '\').html($(this).val());" name="category[22][short_order][' + size_value_row_22 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_22 + '\').remove();updatesizegroup22();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_22').append(html);
                                                                updatesizegroup22();
                        
                                                            }
                                                            var number_group_22 = 0;
                                                            var contentgroup_22 = $('#ybc_group_22').html();
                        
                                                            function addgroup22() {
                                                                number_group_22++;
                                                                html = '';
                                                                html = '<div id="group_22_' + number_group_22 + '" rel="' + number_group_22 + '" class="group_topping">' + contentgroup_22.split("number_group").join(number_group_22); + '</div>'; //
                                                                $('#add_group_22').before(html);
                                                                updatesizegroup22();
                                                            }
                        
                                                            function updatesizegroup22() {
                                                                if ($('.ybc_cat_22 #base_size_22 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_22 #size-value-row_22 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_22_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[22][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_22 #base_size_22 .group_topping').each(function() {
                                                                        $(this).find('.size_22').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_23').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_23').show();
                                                                } else {
                                                                    $('#base_size_23').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_23').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_23').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_23').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_23 = 0;
                        
                                                            function addsizevalue23() {
                                                                size_value_row_23++;
                                                                html = '  <tr rel="' + size_value_row_23 + '" class="size size_' + size_value_row_23 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_23_' + size_value_row_23 + '\').html($(this).val());" name="category[23][size][' + size_value_row_23 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_23_' + size_value_row_23 + '\').html($(this).val());" name="category[23][short_order][' + size_value_row_23 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_23 + '\').remove();updatesizegroup23();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_23').append(html);
                                                                updatesizegroup23();
                        
                                                            }
                                                            var number_group_23 = 0;
                                                            var contentgroup_23 = $('#ybc_group_23').html();
                        
                                                            function addgroup23() {
                                                                number_group_23++;
                                                                html = '';
                                                                html = '<div id="group_23_' + number_group_23 + '" rel="' + number_group_23 + '" class="group_topping">' + contentgroup_23.split("number_group").join(number_group_23); + '</div>'; //
                                                                $('#add_group_23').before(html);
                                                                updatesizegroup23();
                                                            }
                        
                                                            function updatesizegroup23() {
                                                                if ($('.ybc_cat_23 #base_size_23 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_23 #size-value-row_23 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_23_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[23][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_23 #base_size_23 .group_topping').each(function() {
                                                                        $(this).find('.size_23').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                                                        <tr class="ybc_cat_24">
                                                            <td><input type="text" placeholder="Category name" class="valid_name" name="category[24][name]" value=""></td>
                                                            <td><textarea style="width: 100%;" name="category[24][description]"></textarea></td>
                                                            <td valign="top">
                                                                <div class="image"><img src="http://localhost/myfood/image/cache/no_image-100x100.jpg" alt="" id="thumb_24">
                                                                    <input type="hidden" name="category[24][image]" value="" id="image_24">
                                                                    <br>
                                                                    <a onclick="image_upload('image_24', 'thumb_24');">select</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb_24').attr('src', 'http://localhost/myfood/image/cache/no_image-100x100.jpg'); $('#image_24').attr('value', '');">clear</a>
                                                                </div>
                                                            </td>
                                                            <td id="option_24">
                                                                <div id="tab-pizza">
                                                                    <div class="tit-head">
                                                                        <b>SIZE</b>
                                                                        <div class="ed_option">
                                                                            <input onclick="$('#size-value_24').show();" type="radio" value="1" name="category[24][enable_size]"><label>Enable</label>
                                                                            <input onclick="$('#size-value_24').hide();" type="radio" value="0" name="category[24][enable_size]" checked="checked"><label>Disable</label>
                                                                        </div>
                                                                    </div>
                                                                    <table style="display: none;" class="list" id="size-value_24">
                                                                        <thead>
                                                                            <tr>
                                                                                <td class="left">Size</td>
                                                                                <td class="left">Sort Order</td>
                                                                                <td style="width: 10px;"></td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="size-value-row_24">
                                                                            <tr>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot class="sizefoot">
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="left"><a class="button" onclick="addsizevalue24();">Add</a></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <div class="clearets"></div>
                                                                    <div class="tit-head">
                                                                        <b>Options</b>
                                                                        <div class="ed_option">
                                                                            <input class="ispizza_24" name="category[24][ispizza]" type="radio" value="1"><label>Enable </label>
                                                                            <input class="ispizza_24" name="category[24][ispizza]" type="radio" value="0" checked="checked"><label>Disable</label>
                                                                        </div>
                                                                    </div>
                                                                    <div style="display: none;" id="base_size_24">
                                                                        <!-- GROUP -->
                                                                        <p class="sang_custom_add">
                                                                            <a id="add_group_24" class="ybc_add_btn_group button" onclick="addgroup24();return false;">Add</a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="clearets"></div>
                                                                    <div class="tit-head">
                                                                        <b>Comment Box</b>
                                                                        <div class="ed_option">
                                                                            <input onclick="$('#confignumbercharacter_24').show();" name="category[24][enable_comment]" type="radio" value="1"><label>Enable</label>
                                                                            <input onclick="$('#confignumbercharacter_24').hide();" name="category[24][enable_comment]" type="radio" value="0" checked="checked"><label>Disable</label>
                                                                        </div>
                                                                    </div>
                                                                    <div style="display: none;" id="confignumbercharacter_24">
                        
                                                                        <label style="margin-right: 5px;"> Maximum characters allowed</label><input type="text" value="" name="category[24][numbercharacter]">
                        
                        
                                                                    </div>
                                                                    <!-- group -->
                                                                    <div id="ybc_group_24" style="display: none;" class="group_topping">
                                                                        <a class="removegroup" onclick="$('#group_24_number_group').remove();return false;">Remove</a>
                                                                        <table>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><b>Select Option Group: </b></td>
                                                                                    <td>
                                                                                        <select name="category[24][group][number_group][id_group_option]" style="height: 28px;">
                                                                                            </select>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><b>Select Fee Group: </b></td>
                                                                                    <td>
                                                                                        <input name="category[24][group][number_group][set_option]" checked="checked" type="radio" onclick="$('.list_24_number_group').hide();" value="1"><label>Free</label>
                                                                                        <input name="category[24][group][number_group][set_option]" type="radio" onclick="$('.list_24_number_group').hide();" value="2"><label>Main Price</label>
                                                                                        <div class="clearfix"></div>
                                                                                        <input name="category[24][group][number_group][set_option]" type="radio" onclick="$('.list_24_number_group').show();" value="3"><label>Set Price</label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td>
                                                                                        <input name="category[24][group][number_group][set_require]" type="radio" value="1"><label>Required</label>
                                                                                        <input name="category[24][group][number_group][set_require]" checked="checked" type="radio" value="0"><label>Optional</label>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table style="display: none;" class="list_24_number_group">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td class="left">Size</td>
                                                                                    <td>Top Price</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="size_24">
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!-- end group -->
                                                                </div>
                                                            </td>
                                                            <td><a onclick="$('.ybc_cat_24').remove();return false;" href="#" class="button">Delete</a>
                                                                <a></a>
                                                            </td>
                                                        </tr>
                        
                                                        <script type="text/javascript">
                                                            $('.ispizza_24').click(function() {
                                                                if ($(this).val() == 1) {
                                                                    $('#base_size_24').show();
                                                                } else {
                                                                    $('#base_size_24').hide();
                                                                }
                                                            });
                                                            $(document).ready(function() {
                                                                $('.feefree_24').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feemain_24').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').hide();
                                                                });
                                                                $('.feeset_24').click(function() {
                                                                    $(this).parent().parent().parent().parent().parent().find('.list').show();
                                                                });
                                                            });
                                                        </script>
                                                        <script type="text/javascript">
                                                            var size_value_row_24 = 0;
                        
                                                            function addsizevalue24() {
                                                                size_value_row_24++;
                                                                html = '  <tr rel="' + size_value_row_24 + '" class="size size_' + size_value_row_24 + '">';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_24_' + size_value_row_24 + '\').html($(this).val());" name="category[24][size][' + size_value_row_24 + ']" value="" /></td>';
                                                                html += '    <td class="left"><input type="text" onchange="$(\'.ybc_24_' + size_value_row_24 + '\').html($(this).val());" name="category[24][short_order][' + size_value_row_24 + ']" value="" /></td>';
                                                                html += '    <td class="left"><a onclick="$(\'.size_' + size_value_row_24 + '\').remove();updatesizegroup24();" class="button">Delete</a></td>';
                                                                html += '  </tr>';
                                                                $('#size-value-row_24').append(html);
                                                                updatesizegroup24();
                        
                                                            }
                                                            var number_group_24 = 0;
                                                            var contentgroup_24 = $('#ybc_group_24').html();
                        
                                                            function addgroup24() {
                                                                number_group_24++;
                                                                html = '';
                                                                html = '<div id="group_24_' + number_group_24 + '" rel="' + number_group_24 + '" class="group_topping">' + contentgroup_24.split("number_group").join(number_group_24); + '</div>'; //
                                                                $('#add_group_24').before(html);
                                                                updatesizegroup24();
                                                            }
                        
                                                            function updatesizegroup24() {
                                                                if ($('.ybc_cat_24 #base_size_24 .group_topping').length > 0) {
                                                                    html = '';
                                                                    $('.ybc_cat_24 #size-value-row_24 .size').each(function() {
                                                                        html += '<tr class="size_' + $(this).attr('rel') + '">';
                                                                        html += '<td class="left ybc_24_' + $(this).attr('rel') + '">';
                                                                        html += $(this).find('input').val();
                                                                        html += '</td>';
                                                                        html += '<td class="left">';
                                                                        html += '<input type="text" name="category[24][group][ybc_number_group][size][' + $(this).attr('rel') + ']" value="">';
                                                                        html += '</td>';
                                                                        html += '</tr>';
                                                                    });
                                                                    $('.ybc_cat_24 #base_size_24 .group_topping').each(function() {
                                                                        $(this).find('.size_24').html(html.replace(/ybc_number_group/g, $(this).attr('rel')));
                                                                    });
                                                                }
                                                            }
                                                        </script>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td><a style="margin: 10px;float: right;" id="addcatbulk" class="button">Add</a></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="box-footer">
                                            <div class="buttons"><a id="ybcsubmit" class="button">Save</a></div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="http://localhost/myfood/cp/index.php?route=catalog/category/addOptionContent&amp;token=6121b4f1a4de1989c48b4b57e9d1edc5" id="urlajax">
                        
                        
                                <script type="text/javascript">
                                    function image_upload(field, thumb) {
                                        $('#dialog').remove();
                        
                                        $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=6121b4f1a4de1989c48b4b57e9d1edc5&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
                        
                                        $('#dialog').dialog({
                                            title: 'Upload image catagory',
                                            close: function(event, ui) {
                                                if ($('#' + field).attr('value')) {
                                                    $.ajax({
                                                        url: 'index.php?route=common/filemanager/image&token=6121b4f1a4de1989c48b4b57e9d1edc5&image=' + encodeURIComponent($('#' + field).val()),
                                                        dataType: 'text',
                                                        success: function(data) {
                                                            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
                                                        }
                                                    });
                                                }
                                            },
                                            bgiframe: false,
                                            width: 800,
                                            height: 400,
                                            resizable: false,
                                            modal: false
                                        });
                                    };
                                </script>
                        
                                <script>
                                    $(document).ready(function() {
                        
                                        //show menu on mobile    
                                        $(document).on('click', '#toggle_menu_header', function(e) {
                                            if ($('#header').length > 0 && $(window).width() <= 991) {
                                                if ($(this).hasClass('closed_mobile')) {
                                                    $('#header').slideDown(500);
                                                    $(this).removeClass('closed_mobile');
                                                } else {
                                                    $('#header').slideUp(500);
                                                    $(this).addClass('closed_mobile');
                                                }
                                            }
                                        });
                                        //show sub menu when click
                        
                                        $(document).on('click', '.open_sub_menu_mobile', function(e) {
                                            if ($(window).width() <= 991) {
                                                $(this).toggleClass('change_icon_sub').next('ul').toggle(500);
                                                $(this).parent().toggleClass('select_open_sub');
                                            }
                                        });
                        
                                    });
                                </script>






                        </div>
                        {{-- End Card --}}
                    </div>
                </div>
            </div>
        </section>
        {{-- End Form Section --}}

    </div>
</section>
{{-- End Section of List Trasnsactions --}}



@include('footer')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

// $(document).ready(function() {
//     $('#transaction').DataTable();
// } );

// Date Range Picker
$(function() {
    $('input[name="daterange"]').daterangepicker();
});


</script>
