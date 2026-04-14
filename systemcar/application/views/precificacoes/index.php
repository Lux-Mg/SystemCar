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

        <?php if ($message = $this->session->flashdata('info')): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert bg-info alert-info text-white alert-dismissible fade show" role="alert">
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
                        <h3>
                            <a data-toggle="tooltip" data-placement="right" title="Register <?php echo $this->router->fetch_class(); ?>" class="btn bg-blue text-white float-right" href="<?php echo base_url($this->router->fetch_class() . '/core/'); ?>">&nbsp;<i class="far fa-file"></i>New</a>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <?php $currency = $this->config->item('currency_symbol'); ?>
                            <table class="table data-table table-sm pl-10 pr-10">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Hour Value</th>
                                        <th>Monthly Fee</th>
                                        <th class="text-center">Number of Spots</th>
                                        <th>Active</th>
                                        <th class="nosort text-right pr-30">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($precificacoes as $categoria): ?>
                                    <tr>
                                        <td><?php echo $categoria->precificacao_id; ?></td>
                                        <td><?php echo $categoria->precificacao_categoria; ?></td>
                                        <td><?php echo $currency.'&nbsp;'.$categoria->precificacao_valor_hora; ?></td>
                                        <td><?php echo $currency.'&nbsp;'.$categoria->precificacao_valor_mensalidade; ?></td>
                                        <td class="text-center"><?php echo $categoria->precificacao_numero_vagas; ?></td>
                                        <td><?php echo ($categoria->precificacao_ativa == 1 ? '<span class="badge badge-pill badge-success mb-1"><i class="fas fa-lock-open"></i>&nbsp;Yes</span>' : '<span class="badge badge-pill badge-warning mb-1"><i class="fas fa-lock"></i>&nbsp;No</span>'); ?></td>
                                        <td class="text-right">
                                            <a data-toggle="tooltip" data-placement="bottom" title="Edit <?php echo $this->router->fetch_class();?>" href="<?php echo base_url($this->router->fetch_class() . '/core/' . $categoria->precificacao_id); ?>" class="btn btn-icon btn-primary"><i class="ik ik-edit-2"></i></a>
                                            <button type="button" title="Delete <?php echo $this->router->fetch_class(); ?>" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#categoria-<?php echo $categoria->precificacao_id; ?>"><i class="ik ik-trash"></i></button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="categoria-<?php echo $categoria->precificacao_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterLabel"><i class="fas fa-exclamation-circle text-danger"></i>&nbsp;Are you sure you want to delete this record?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>By clicking <strong>YES</strong> the record will be permanently deleted!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button data-toggle="tooltip" data-placement="bottom" title="Cancel deletion" type="button" class="btn btn-secondary" data-dismiss="modal">No, Go Back</button> 
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Delete <?php echo $this->router->fetch_class();?>" href="<?php echo base_url($this->router->fetch_class() . '/del/' . $categoria->precificacao_id); ?>" class="btn btn-danger">Yes, Delete</a>
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


