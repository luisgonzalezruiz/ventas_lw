<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <div class="table-responsive tblscroll" style="max-height:650px; overflow:hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3b3f5c">
                            <tr>
                                <th width="10%"></th>
                                <th class="table-th text-white">DESCRIPCÍON</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th width="13%" class="table-th text-white text-center">CANT</th>
                                <th class="table-th text-white text-center">IMPORTE</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>