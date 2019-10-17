@extends('layouts.master')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Info</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Icon</th>
                <th>Date</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($informations as $information)
            <tr class="detail-info" data-id="{{ $information->id }}" data-action="{{ route('details') }}">
                <td>{{ $information->icon ? $leadInfo->icon : '' }}</td>
                <td>{{ $information->date->format('d.m.Y') }}</td>
                <td>{{ $information->name }}</td>
                <td>{{ $information->phone ? $information->phone->phone : '' }}</td>
                <td>{{ $information->email }}</td>
            </tr>
            <tr id="single-{{$information->id}}" style="display: none;" >
                <td colspan="4"></td>
            </tr>
           @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.detail-info').click(function () {
                var $this = $(this)
                var id = $this.data('id');
                var single = $('#single-'+id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: 'html',
                    url: $this.data('action'),
                    data: {'id':id},
                    success: function (data) {
                        if(single.hasClass('expand')) {
                            single.fadeOut().removeClass('expand');
                        }else {
                            single.fadeIn().addClass('expand')
                                .find('td').html(data);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus) {
                        alert(textStatus);
                    },
                });

            })
        });
    </script>
@endsection