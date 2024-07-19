@php
 $clients=App\User::where('role',3)->orderBy('id','DESC')->take(5)->get();
@endphp

<br>
<div class="card">
    <div class="card-body">
        <h3>Recent Clients</h3>
        <div class="table-responsive">
            <table class="table  table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Orders</th>                  
                        <th scope="col" >Action</th>
                    </tr>
                </thead>
                <tbody style="font-size:14px">
                    @if(count($clients)>0)
                    @foreach ( $clients as $key=>$client )
                    @php
							$orders=App\Order::where('user_id',$client->id)->count();
							@endphp	
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        
                        <td>
                            <p>{{ $client->name }}</p>
                            <p>{{ $client->phone }}</p>
                        </td>
                        <td>{{ $client->email }}</td>
                       
                        <td>
                            {{$orders}}
                        </td>
                        <td>
                            <a href="{{ url('/profile',$client->id) }}">View Profile</a>
                        </td>
                       
                    </tr>
                    @endforeach
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
    </div>
