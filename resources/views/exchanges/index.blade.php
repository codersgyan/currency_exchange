    @extends('layouts.app')
    @section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div>
                    <form action="" class="d-flex flex-row mb-2">
                    <div class="form-group mr-4">
                        <label for="exampleFormControlInput1">Название</label>
                        <input type="text" class="form-control" name="valute" value="{{ Request::get('valute') }}" id="exampleFormControlInput1" placeholder="Например USD">
                      </div>

                      <div class="form-group mr-4">
                        <label for="exampleFormControlSelect1">Сортировать</label>
                        <select class="form-control" name="order" id="exampleFormControlSelect1">
                          <option value="asc" {{ Request::get('order')==='asc'?'selected':'' }}>A-Z</option>
                          <option value="desc" {{ Request::get('order')==='desc'?'selected':'' }}>Z-A</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">Дата</label>
                        <div class="d-flex">
                        <input type="date" name="date" value="{{ Request::get('date') }}" class="form-control mr-4" id="exampleFormControlInput1">
                        <button type="submit" class="btn btn-primary mr-4">Search</button>
                        <a class="btn btn-secondary" href="/exchange-rates">Reset</a>
                        </div>
                      </div>
                      </form>

                </div>
                <table class="table table-striped table-light mt-5">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Currency Code</th>
                      <th scope="col">Currency Name</th>
                      <th scope="col">Nominal</th>
                      <th scope="col">Value</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($currencies as $currency)
                    <tr>
                      <th scope="row">{{ $currency->currency_id }}</th>
                      <td>{{ $currency->currency_code }}</td>
                      <td>{{ $currency->currency_name }}</td>
                      <td>{{ $currency->nominal }}</td>
                      <td>{{ $currency->value }}</td>
                      <td>{{ date('d.m.y',strtotime($currency->created_at)) }}</td>
                    </tr>
                    @empty
                      <div class="alert alert-warning mt-5" role="alert">
                        No results.
                      </div>
                    @endforelse
                  </tbody>
                </table>
                <div class="pagination mt-4">
                {!! $currencies->appends(request()->input())->links() !!}
                </div>
            </div>
        </div>
    </div>
    @endsection
