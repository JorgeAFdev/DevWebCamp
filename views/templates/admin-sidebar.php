<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__link <?php echo current_page('/dashboard') ? 'dashboard__link--current' : ''; ?>">
            <i class="fa-solid fa-house dashboard__icon"></i>
            <span class="dashboard__text-menu"> 
                Start
            </span>
        </a>

        <a href="/admin/speakers" class="dashboard__link <?php echo current_page('/speakers') ? 'dashboard__link--current' : ''; ?>">
            <i class="fa-solid fa-microphone dashboard__icon"></i>
            <span class="dashboard__text-menu"> 
                Speakers
            </span>
        </a>

        <a href="/admin/events" class="dashboard__link <?php echo current_page('/events') ? 'dashboard__link--current' : ''; ?>">
            <i class="fa-solid fa-calendar dashboard__icon"></i>
            <span class="dashboard__text-menu"> 
                Events
            </span>
        </a>

        <a href="/admin/registered" class="dashboard__link <?php echo current_page('/registered') ? 'dashboard__link--current' : ''; ?>">
            <i class="fa-solid fa-users dashboard__icon"></i>
            <span class="dashboard__text-menu"> 
                Registered
            </span>
        </a>

        <a href="/admin/gifts" class="dashboard__link <?php echo current_page('/gifts') ? 'dashboard__link--current' : ''; ?>">
            <i class="fa-solid fa-gift dashboard__icon"></i>
            <span class="dashboard__text-menu"> 
                Gifts
            </span>
        </a>
    </nav>
</aside>