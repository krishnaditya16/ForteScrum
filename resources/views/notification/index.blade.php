<li class="dropdown dropdown-list-toggle pr-3">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg @if (Auth::user()->name == 'test') beep @else @endif"><i class="far fa-bell"></i></a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
            <div class="float-right">
                <a href="#">Mark All As Read</a>
            </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="dropdown-item-desc">
                    Project has been created!
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="dropdown-item-desc">
                    Sprint has been created!
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="dropdown-item-desc">
                    Backlog has been created!
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-code"></i>
                </div>
                <div class="dropdown-item-desc">
                    Task has been created!
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-success text-white">
                    <i class="fas fa-check"></i>
                </div>
                <div class="dropdown-item-desc">
                    Task has been marked as done!
                    <div class="time text-primary">2 Min Ago</div>
                </div>
            </a>
        </div>
        <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>
