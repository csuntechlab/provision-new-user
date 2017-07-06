<div class="header">
    <nav class="primary-nav">
        <div class="container">
            <div class="primary-nav__mobile">
                <div class="primary-nav__btn">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
                <a href="//www.metalab.csun.edu" class="primary-nav__brand"><span class="sr-only">Matador Emerging Technology and Arts Lab</span></a>
                <a href="{{ url('/')  }}" class="primary-nav__sub-brand">Provision Google Apps User</a>
                <a class="sr-only" href="#main">Skip to main content</a>
            </div>
        </div>
    </nav>
</div>

@if(count($errors) > 0)
    <div class="alert alert--danger">
        <p>The following errors occurred:</p>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif(session('success'))
    <div class="alert alert--success" style="color:white">
        {{ session('success') }}
    </div>
@endif