<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">

			<ul>
				<li class="menu-title">
					<span>Menu</span>
				</li>
				<li class="{{ route_is('dashboard') ? 'active' : '' }}">
					<a href="{{route('dashboard')}}"><i class="fe fe-home"></i> <span>Tableau de bord</span></a>
				</li>

				@can('view-category')
				<li class="{{ route_is('categories.*') ? 'active' : '' }}">
					<a href="{{route('categories.index')}}"><i class="fe fe-layout"></i> <span>Categories</span></a>
				</li>
				@endcan

				@can('view-modalite')
				<li class="{{ route_is('modalites.*') ? 'active' : '' }}">
					<a href="{{route('modalites.index')}}"><i class="fe fe-layout"></i> <span>Modalités</span></a>
				</li>
				@endcan

				@can('view-departement')
				<li class="{{ route_is('departements.*') ? 'active' : '' }}">
					<a href="{{route('departements.index')}}"><i class="fe fe-layout"></i> <span>Départements</span></a>
				</li>
				@endcan

				@can('view-products')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> Products</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is(('products.*')) ? 'active' : '' }}" href="{{route('products.index')}}">Products</a></li>
						@can('create-product')<li><a class="{{ route_is('products.create') ? 'active' : '' }}" href="{{route('products.create')}}">Add Product</a></li>@endcan
						@can('view-outstock-products')<li><a class="{{ route_is('outstock') ? 'active' : '' }}" href="{{route('outstock')}}">Out-Stock</a></li>@endcan
						@can('view-expired-products')<li><a class="{{ route_is('expired') ? 'active' : '' }}" href="{{route('expired')}}">Expired</a></li>@endcan
					</ul>
				</li>
				@endcan

				@can('view-purchase')
				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Purchase</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('purchases.*') ? 'active' : '' }}" href="{{route('purchases.index')}}">Purchase</a></li>
						@can('create-purchase')
						<li><a class="{{ route_is('purchases.create') ? 'active' : '' }}" href="{{route('purchases.create')}}">Add Purchase</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-equipement')
				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Equipements</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('equipements.*') ? 'active' : '' }}" href="{{route('equipements.index')}}">Equipements</a></li>
						@can('create-equipement')
						<li><a class="{{ route_is('equipements.create') ? 'active' : '' }}" href="{{route('equipements.create')}}">Ajouter Equipement</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-sousequipement')
				<li class="submenu">
					<a href="#"><i class="fe fe-star-o"></i> <span> Sous Equipements</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('sousequipements.*') ? 'active' : '' }}" href="{{route('sousequipements.index')}}">Sous Equipements</a></li>
					</ul>
				</li>
				@endcan

				@can('view-intervention')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> Interventions</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('interventions.*') ? 'active' : '' }}" href="{{route('interventions.index')}}">Interventions</a></li>
                        <li><a class="{{ route_is('interventions.*') ? 'active' : '' }}" href="{{route('interventions.archive')}}">Clôturées</a></li>
						<li><a class="{{ route_is('interventions.*') ? 'active' : '' }}" href="{{route('interventions.unclosed')}}">Non Clôturées</a></li>
                        @can('create-intervention')
						<li><a class="{{ route_is('interventions.create') ? 'active' : '' }}" href="{{route('interventions.create')}}">Ajouter Intervention</a></li>
						@endcan
					</ul>
				</li>
				@endcan


				<li class="{{ route_is('calender.*') ? 'active' : '' }}">
				<a href="/calender"><i class="fa fa-calendar"></i><span>Plan Maintenance</span></a>
				</li>

				@can('view-contrat')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span>Contrats</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('contrats.*') ? 'active' : '' }}" href="{{route('contrats.index')}}">Contrats</a></li>
						@can('create-contrat')
						<li><a class="{{ route_is('contrats.create') ? 'active' : '' }}" href="{{route('contrats.create')}}">Ajouter contrat</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-sales')
				<li class="submenu">
					<a href="#"><i class="fe fe-activity"></i> <span> Sale</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('sales.*') ? 'active' : '' }}" href="{{route('sales.index')}}">Sales</a></li>
						@can('create-sale')
						<li><a class="{{ route_is('sales.create') ? 'active' : '' }}" href="{{route('sales.create')}}">Add Sale</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-supplier')
				<li class="submenu">
					<a href="#"><i class="fe fe-user"></i> <span> Supplier</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('suppliers.*') ? 'active' : '' }}" href="{{route('suppliers.index')}}">Supplier</a></li>
						@can('create-supplier')<li><a class="{{ route_is('suppliers.create') ? 'active' : '' }}" href="{{route('suppliers.create')}}">Add Supplier</a></li>@endcan
					</ul>
				</li>
				@endcan

				<!-- clients -->
				@can('view-client')
				<li class="submenu">
					<a href="#"><i class="fe fe-user"></i> <span> Clients</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('clients.*') ? 'active' : '' }}" href="{{route('clients.index')}}">Clients</a></li>
						@can('create-client')<li><a class="{{ route_is('clients.create') ? 'active' : '' }}" href="{{route('clients.create')}}">Ajouter Client</a></li>@endcan
					</ul>
				</li>
				@endcan

                <!-- sous traitants -->
				@can('view-soustraitant')
				<li class="submenu">
					<a href="#"><i class="fe fe-user"></i> <span>Sous-traitants</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a class="{{ route_is('soustraitants.*') ? 'active' : '' }}" href="{{route('soustraitants.index')}}">Sous-traitants</a></li>
						@can('create-soustraitant')<li><a class="{{ route_is('soustraitants.create') ? 'active' : '' }}" href="{{route('soustraitants.create')}}">Ajouter Sous-traitant</a></li>@endcan
					</ul>
				</li>
				@endcan

				@can('view-reports')
				<li class="submenu">
					<a href="#"><i class="fe fe-document"></i> <span> Rapports</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<!--
						<li><a class="{{ route_is('sales.report') ? 'active' : '' }}" href="{{route('sales.report')}}">Sale Report</a></li>
						<li><a class="{{ route_is('purchases.report') ? 'active' : '' }}" href="{{route('purchases.report')}}">Purchase Report</a></li>
						-->
						<li><a class="{{ route_is('equipements.report') ? 'active' : '' }}" href="{{route('equipements.report')}}">Rapport Equipements</a></li>
						<li><a class="{{ route_is('interventions.report') ? 'active' : '' }}" href="{{route('interventions.report')}}">Rapport Interventions</a></li>
                        <li><a class="{{ route_is('contrats.report') ? 'active' : '' }}" href="{{route('contrats.report')}}">Rapport Contrats</a></li>
                    </ul>
				</li>
				@endcan

				@can('view-access-control')
				<li class="submenu">
					<a href="#"><i class="fe fe-lock"></i> <span>Contrôle d'Accès</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						@can('view-permission')
						<li><a class="{{ route_is('permissions.index') ? 'active' : '' }}" href="{{route('permissions.index')}}">Permissions</a></li>
						@endcan
						@can('view-role')
						<li><a class="{{ route_is('roles.*') ? 'active' : '' }}" href="{{route('roles.index')}}">Rôles</a></li>
						@endcan
					</ul>
				</li>
				@endcan

				@can('view-users')
				<li class="{{ route_is('users.*') ? 'active' : '' }}">
					<a href="{{route('users.index')}}"><i class="fe fe-users"></i> <span>Utilisateurs</span></a>
				</li>
				@endcan


				@can('view-etat')
				<li class="{{ route_is('etats.*') ? 'active' : '' }}">
					<a href="{{route('etats.index')}}"><i class="fe fe-layout"></i> <span>Etat Maintenance</span></a>
				</li>
				@endcan

				<li class="{{ route_is('profile') ? 'active' : '' }}">
					<a href="{{route('profile')}}"><i class="fe fe-user-plus"></i> <span>Profil</span></a>
				</li>
				<li class="{{ route_is('backup.index') ? 'active' : '' }}">
					<a href="{{route('backup.index')}}"><i class="material-icons">backup</i> <span>Sauvegarde</span></a>
				</li>
				@can('view-settings')
				<li class="{{ route_is('settings') ? 'active' : '' }}">
					<a href="{{route('settings')}}">
						<i class="material-icons">settings</i>
						 <span> Paramètres</span>
					</a>
				</li>
				@endcan
			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->
