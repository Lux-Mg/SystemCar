<?php $this->load->view('layout/navbar'); ?>

<div class="page-wrap">

<?php $this->load->view('layout/sidebar'); ?>
   
<div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                        <i class="<?php echo $icone_view; ?> bg-blue"></i>
                            <div class="d-inline">
                                <h5><?php echo $titulo ?></h5>
                                <span><?php echo $sub_titulo ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a title="Home" href="<?php echo base_url('/'); ?>"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?php if ($message = $this->session->flashdata('sucesso')): ?>
                <div class="row">
                <div class="col-md-12">
                <div class="alert bg-success alert-success text-white alert-dismissible fade show" role="alert">
                    <strong><i class="far fa-smile-wink"></i>&nbsp;<?php echo $message ?></strong> 
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                    </button>
                     </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($message = $this->session->flashdata('error')): ?>
                <div class="row">
                <div class="col-md-12">
                <div class="alert bg-danger alert-danger text-white alert-dismissible fade show" role="alert">
                    <strong><i class="far fa-smile-wink"></i>&nbsp;<?php echo $message ?></strong> 
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                    </button>
                     </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header d-block">
                <a class="btn bg-blue float-right text-white" data-toggle="tooltip" data-placement="right" title="Register <?php echo $this->router->fetch_class(); ?>"
                href="<?php echo base_url($this->router->fetch_class().'/core/'); ?>">+ New</a>
            </div>

            <div class="card-body">
            <div class="table-responsive-sm">
            <?php $currency = $this->config->item('currency_symbol'); ?>
            <table class="table data-table table-sm pl-10 pr-10">
    <thead>
        <tr>
            <th>#</th>
            <th>Subscriber</th>
            <!-- <th>CPF</th> -->
            <th>Category</th>
            <th>Monthly Fee Value</th>
            <th>Due Date</th>
            <th>Payment Date</th>
            <th>Status</th>
            <th class="nosort text-right pr-25">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mensalidades as $mensalidade) : ?>
            <tr>
                <td><?php echo $mensalidade->mensalidade_id ; ?></td>
                <td>
                    <i class="ik ik-eye text-info"></i>&nbsp;
                    <a data-toggle="tooltip" data-placement="bottom" title="View subscriber <?php echo $mensalidade->mensalista_nome ; ?>" href="<?php echo base_url('mensalistas/core/'.$mensalidade->mensalidade_id); ?> ">
                        <?php echo $mensalidade->mensalista_nome ; ?>
                    </a>
                </td>
                <!-- <td><?php // echo $mensalidade->mensalista_cpf ; ?></td> -->
                <td><?php echo $mensalidade->precificacao_categoria ; ?></td>
                <td><?php echo $currency.'&nbsp;'.$mensalidade->precificacao_valor_mensalidade ; ?></td>
                <td><?php echo formata_data_banco_sem_hora($mensalidade->mensalidade_data_vencimento) ; ?></td>
                <td><?php echo ($mensalidade->mensalidade_status == 1 ? formata_data_banco_sem_hora($mensalidade->mensalidade_data_pagamento) : 'Open' ); ?></td>
                <td class="text-center">
                <?php
                if ($mensalidade->mensalidade_status == 1) {
                   echo '<span class="badge badge-pill badge-success mb-1">Paid</span>';
                } else if(strtotime($mensalidade->mensalidade_data_vencimento) > strtotime(date('Y-m-d'))) {
                   echo '<span class="badge badge-pill badge-yellow text-white mb-1">To receive</span>';
                } else if(strtotime($mensalidade->mensalidade_data_vencimento) == strtotime(date('Y-m-d'))) {
                   echo '<span class="badge badge-pill badge-info mb-1">Due today</span>';
                } else {
                   echo '<span class="badge badge-pill badge-danger mb-1">Overdue</span>';
                }
                 ?>
                </td>
                <td>
                    <div class="text-right">
                        <a data-toggle="tooltip" data-placement="bottom" title="<?php echo($mensalidade->mensalidade_status == 1 ? 'View' : 'Edit' )?> <?php echo $this->router->fetch_class(); ?>" href="<?php echo base_url($this->router->fetch_class().'/core/'. $mensalidade->mensalidade_id); ?>" class="btn btn-icon btn-primary"><i class="<?php echo ($mensalidade->mensalidade_status == 1 ? 'ik ik-eye': 'ik ik-edit-2')?>"></i></a>
                        <button type="button"  class="btn btn-icon btn-danger" data-toggle="modal" data-target="#mensalidade-<?php echo $mensalidade->mensalidade_id; ?>"><i class="ik ik-trash-2"></i></button> 
                    </div>
                </td>
            </tr>

            <div class="modal fade" id="mensalidade-<?php echo $mensalidade->mensalidade_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterLabel"><i class="fas fa-exclamation-triangle text-danger"></i>&nbsp;Are you sure you want to delete this record?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                          <p>If you want to delete the record, click <strong>Yes, Delete</strong></p>
                      </div>
                      <div class="modal-footer">
                        <button  type="button" data-toggle="tooltip" data-placement="bottom" title="Cancel" class="btn btn-secondary" data-dismiss="modal">No, Go Back</button>
                        <a data-toggle="tooltip" data-placement="bottom" title="Delete <?php echo $this->router->fetch_class(); ?>" href="<?php echo base_url($this->router->fetch_class().'/del/'. $mensalidade->mensalidade_id); ?>" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </div>
          </div>   

        <?php endforeach; ?>
    </tbody>
</table>
                </div>

            </div>
        </div>
    </div>
</div>
        </div>
    </div>

    <footer class="footer">
        <div class="w-100 clearfix">
            <span class="text-center text-sm-left d-md-inline-block">
                Copyright © <?php echo date('Y'); ?> System Car. All rights reserved.
            </span>
            <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">
                Developed <i class="fas fa-code text-dark"></i>&nbsp;by:&nbsp;
                <a href="https://github.com/Lux-Mg" class="text-dark" target="_blank">Luis Mendoza</a>
            </span>
        </div>
    </footer>
</div>


