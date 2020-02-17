<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="titulo">Categoría</label>
    <div class="col-md-9">
        <select class="form-control" name="id" id="id" required>
            <option value="0" disabled>Seleccione</option>
            @foreach ($categorias as $cat)
                <option value="{{$cat->id}}">{{$cat->nombre}}</option>
            @endforeach
        </select>
    </div>
</div>



<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="codigo">Código</label>
    <div class="col-md-9">
        <input type="text" class="form-control"  id="codigo" name="codigo" placeholder="Ingrese el codigo" required pattern="[0-9]{0,15}">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="stock">Stock</label>
    <div class="col-md-9">
    <input type="text" class="form-control" id="stock" name="stock"  placeholder="Ingrese el stock" disabled>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="nombre">Nombre</label>
    <div class="col-md-9">
    <input type="text" class="form-control" id="nombre" name="nombre"  placeholder="Ingrese el nombre" required pattern="^[a-zA-Z_áéíóúñ\s]{0,100}$">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="precio_venta">Precio de venta</label>
    <div class="col-md-9">
    <input type="number" class="form-control" id="precio_venta" name="precio_venta"  placeholder="Ingrese el nombre" required pattern="^[a-zA-Z_áéíóúñ\s]{0,100}$">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="imagen">Imagen</label>
    <div class="col-md-9">
    <input type="file" class="form-control" id="imagen" name="imagen"  placeholder="Ingrese el nombre">
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
</div>
