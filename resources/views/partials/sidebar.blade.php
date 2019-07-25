@inject('request', 'Illuminate\Http\Request')
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                    <a href="{{ url('/') }}">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>            
                @can('patient_access')
                <li class="{{ $request->segment(2) == 'patients' ? 'active' : '' }}">
                    <a href="{{ route('admin.patients.index') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">Patients</span>
                    </a>
                </li>
                @endcan   
                @can('patient_info')
                <li class="{{ $request->segment(2) == 'patients' ? 'active' : '' }}">
                    <a href="{{ route('admin.patients.get_info') }}">
                        <i class="fa fa-user"></i>
                        <span class="title">Personal Information</span>                    
                    </a>
                </li>
                @endcan         
                @can('doctor_access')
                <li class="{{ $request->segment(2) == 'doctors' ? 'active' : '' }}">
                    <a href="{{ route('admin.doctors.index') }}">
                        <i class="fa fa-user-md"></i>
                        <span class="title">Doctors</span>
                    </a>
                </li>
                @endcan
                @can('nurse_access')
                <li class="{{ $request->segment(2) == 'nurses' ? 'active' : '' }}">
                    <a href="{{ route('admin.nurses.index') }}">
                        <i class="fa fa-heartbeat"></i>
                        <span class="title">Nurses</span>
                    </a>
                </li>
                @endcan             
                @can('working_hour_access')
                <li class="{{ $request->segment(2) == 'working_hours' ? 'active' : '' }}">
                    <a href="{{ route('admin.working_hours.index') }}">
                        <i class="fa fa-hourglass"></i>
                        <span class="title">Working Hours</span>
                    </a>
                </li>
                @endcan
                @can('service_access')
                <li class="{{ $request->segment(2) == 'services' ? 'active' : '' }}">
                    <a href="{{ route('admin.services.index') }}">
                        <i class="fa fa-stethoscope"></i>
                        <span class="title">Services</span>
                    </a>
                </li>
                @endcan            
                @can('appointment_access')
                <li class="{{ $request->segment(2) == 'appointments' ? 'active' : '' }}">
                    <a href="{{ route('admin.appointments.index') }}">
                        <i class="fa fa-calendar"></i>
                        <span class="title">Appointemnts</span>
                    </a>
                </li>
                @endcan
                @can('appointment_info')
                <li class="{{ $request->segment(2) == 'appointments' ? 'active' : '' }}">
                    <a href="{{ route('admin.appointments.get_appt') }}">
                        <i class="fa fa-calendar"></i>
                        <span class="title">Appointments</span>
                    </a>
                </li>
                @endcan
                @can('user_management_access')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span class="title">User Management</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style:"display: none;">
                            @can('role_access')
                                <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                                    <a href="{{ route('admin.roles.index') }}">
                                        <i class="fa fa-briefcase"></i>
                                        <span class="title">
                                            Roles
                                        </span>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                                    <a href="{{ route('admin.users.index') }}">
                                        <i class="fa fa-user"></i>
                                        <span class="title">
                                            Users
                                        </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                    <a href="{{ route('auth.change_password') }}">
                        <i class="fa fa-key"></i>
                        <span class="title">Change password</span>
                    </a>
                </li>
                <li>
                    <a href="#logout" onclick="$('#logout').submit();">
                        <i class="fa fa-arrow-left"></i>
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>

    {!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
    <button type="submit">Logout</button>
    {!! Form::close() !!}
