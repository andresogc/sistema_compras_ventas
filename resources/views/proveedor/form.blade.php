 <div class="form-group row">
    <label class="col-md-3 form-control-label"  for="nombre">Nombre</label>
    <div class="col-md-9">
        <input type="text" class="form-control"  id="nombre" name="nombre" placeholder="Ingrese el nombre" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
    </div>
</div>



<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="direccion">Dirección</label>
    <div class="col-md-9">
        <input type="text" class="form-control"  id="direccion" name="direccion" placeholder="Ingrese la direccion" required pattern="^[a-zA-Z_0-9_áéíóúñªº#-\s]{0,200}$">
    </div>
</div>


<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="titulo">Documento</label>
    <div class="col-md-9">
        <select class="form-control" name="tipo_documento" id="tipo_documento" required>
            <option value="0"  selected>Seleccione</option>
            <option value="DNI">DNI</option>
            <option value="CEDULA">CEDULA</option>
            <option value="NIT">NIT</option>
        </select>
    </div>
</div>


<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="stock">Número de documento</label>
    <div class="col-md-9">
    <input type="text" class="form-control" id="num_documento" name="num_documento"  placeholder="Ingrese el número de documento" pattern="[0-9]{0,15}">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="nombre">Teléfono</label>
    <div class="col-md-9">
    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="Ingrese el teléfono" pattern="[0-9]{0,15}">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label"  for="email">Email</label>
    <div class="col-md-9">
    <input type="email" class="form-control" id="email" name="email"  placeholder="Ingrese el email" >
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
</div>

