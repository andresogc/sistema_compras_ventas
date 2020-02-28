<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{url('home')}}" onclick="event.preventDefault(); document.getElementById('home-form').submit();"><i class="fa fa-list"></i> Dashboard</a>
                <form id="home-form" action="{{url('home')}}"  method="GET" style="display:none;">
                    @csrf
                </form>
            </li>
            <li class="nav-title">
                Menú
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{url('categoria')}}" onclick="event.preventDefault(); document.getElementById('categoria-form').submit();"><i class="fa fa-list"></i> Categorías</a>

                <form id="categoria-form" action="{{url('categoria')}}"  method="GET" style="display:none;">
                    @csrf
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('producto')}}" onclick="event.preventDefault(); document.getElementById('producto-form').submit();"><i class="fa fa-list"></i> Productos</a>

                <form id="producto-form" action="{{url('producto')}}"  method="GET" style="display:none;">
                    @csrf
                </form>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('compras')}}" onclick="event.preventDefault(); document.getElementById('compras-form').submit();"><i class="fa fa-list"></i> Compras</a>

                <form id="compras-form" action="{{url('compras')}}" method="GET" style="display:none;">
                    @csrf
                </form>
             </li>

            <li class="nav-item">
                <a class="nav-link" href="{{url('proveedor')}}" onclick="event.preventDefault(); document.getElementById('proveedor-form').submit();"><i class="fa fa-list"></i> Proveedores</a>

                <form id="proveedor-form" action="{{url('proveedor')}}" method="GET" style="display:none;">
                    @csrf
                </form>
             </li>




           
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
