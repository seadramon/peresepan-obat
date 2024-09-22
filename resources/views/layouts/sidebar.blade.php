<aside class="main-sidebar sidebar-dark-primary elevation-5">
	<!-- Brand Logo -->
	<a href="/" class="brand-link" style="font-size: 1.15rem;">
		<span class="brand-text font-weight-light">Medication Prescribing</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ Avatar::create(\Auth::user()->name)->toBase64() }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">{{\Auth::user()->name}}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
						 with font-awesome or any other icon font library -->
				
				<li class="nav-item">
					<a href="{{ route('dashboard') }}" class="nav-link {{ $elementActive == 'home' ? 'active' : '' }}">
						<i class="nav-icon fas fa-home"></i>
						<p>
							Home
						</p>
					</a>
				</li>
				@if (myRole() == 'dokter')
					<li class="nav-item {{ $parentActive == 'master' ? 'menu-open' : '' }}">
			            <a href="#" class="nav-link {{ $parentActive == 'master' ? 'active' : '' }}">
			              	<i class="nav-icon fas fa-user-friends"></i>
			              	<p>
			                	Master
			                	<i class="right fas fa-angle-left"></i>
			              	</p>
			            </a>
			            <ul class="nav nav-treeview">
			              	<li class="nav-item">
			                	<a href="{{ route('tanda-vital.index') }}" class="nav-link {{ $elementActive == 'tanda-vital' ? 'active' : '' }}">
			                  	<i class="far fa-circle nav-icon"></i>
			                  	<p>Tanda Vital</p>
			                	</a>
			              	</li>
			            </ul>
			        </li>
					<li class="nav-item">
						<a href="{{ route('hasil-pemeriksaan.index') }}" class="nav-link {{ $elementActive == 'hasil-pemeriksaan' ? 'active' : '' }}">
							<i class="nav-icon fas fa-home"></i>
							<p>
								Hasil Pemeriksaan
							</p>
						</a>
					</li>
				@endif

				@if (myRole() == 'apoteker')
					<li class="nav-item">
						<a href="{{ route('resep.index') }}" class="nav-link {{ $elementActive == 'resep' ? 'active' : '' }}">
							<i class="nav-icon fas fa-home"></i>
							<p>
								Pelayanan Resep
							</p>
						</a>
					</li>
				@endif
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>