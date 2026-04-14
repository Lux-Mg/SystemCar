<header class="header-top" header-theme="dark">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
                        </div>
                        <div class="top-menu d-flex align-items-center">

                          <?php if($this->router->fetch_class() == 'home' && isset($notificacoes)):?>
                           <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="blink_me"><i class="ik ik-bell"></i><span class="badge bg-danger"><?php echo $notificacoes; ?></span></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                                    <h4 class="header">Notification Center</h4>
                                    <div class="notifications-wrap">
                                          <?php if (isset($mensalidades_vencidas)): ?>
                                            <a href="<?php echo base_url('mensalidades'); ?>" class="media">
                                            <span class="d-flex">
                                             <i class="fas fa-hand-holding-usd bg-warning"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">There are overdue monthly fees</span>
                                            </span>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (isset($precificacoes_inativas)): ?>
                                            <a href="<?php echo base_url('precificacoes'); ?>" class="media">
                                            <span class="d-flex">
                                             <i class="fas fa-dollar-sign bg-warning"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">There are inactive pricings</span> 
                                            </span>
                                              </a>
                                            <?php endif; ?>

                                            <?php if (isset($formas_inativas)): ?>
                                            <a href="<?php echo base_url('formas'); ?>" class="media">
                                            <span class="d-flex">
                                             <i class="fas fa-comment-dollar bg-warning"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">There are inactive payment methods</span> 
                                            </span>
                                              </a>
                                            <?php endif; ?>

                                            <?php if (isset($usuarios_inativos)): ?>
                                            <a href="<?php echo base_url('usuarios'); ?>" class="media">
                                            <span class="d-flex">
                                             <i class="fas fa-user-friends bg-warning"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">There are inactive users</span> 
                                            </span>
                                              </a>
                                            <?php endif; ?>

                                            <?php if (isset($mensalistas_inativos)): ?>
                                            <a href="<?php echo base_url('mensalistas'); ?>" class="media">
                                            <span class="d-flex">
                                             <i class="fas fa-users bg-warning"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading">There are inactive monthly clients</span> 
                                            </span>
                                              </a>
                                            <?php endif; ?>

                                    </div>
                                    <div class="footer">Don't forget to check!</div>
                                </div>
                            </div>
                          <?php endif; ?>
                            
                            <button type="button" class="nav-link ml-10" id="apps_modal_btn" data-toggle="modal" data-target="#appsModal"><i class="ik ik-grid"></i></button>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-user ik-2x text-white"></i></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a data-toggle="tooltip" data-placement="left" title="Manage profile" class="dropdown-item" href="<?php echo base_url('usuarios/core/'.$this->session->userdata('user_id')); ?>"><i class="ik ik-user dropdown-icon"></i>Profile</a>
                                    <a data-toggle="tooltip" data-placement="left" title="Logout" class="dropdown-item" href="<?php echo base_url('login/logout'); ?>"><i class="ik ik-power dropdown-icon"></i>Logout</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>