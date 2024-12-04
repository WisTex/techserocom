<!-- ============================================ -->
<!--                     Blog                     -->
<!-- ============================================ -->

<section id="blog-986">
    <div class="cs-container">
        <div class="cs-content">
            <div class="cs-flex">
                <span class="cs-topper">Content Management</span>
                <h2 class="cs-title">{{$widget_title}}</h2>
            </div>
            <a href="channel/{{$posts[0].channel_address}}" class="cs-button-solid">View All</a>
        </div>
        <ul class="cs-card-group">
        {{foreach $posts as $post}}
            <li class="cs-item">
                <picture class="cs-picture">
                    {{if $post.image}}
                        <!--Mobile Image-->
                        <source media="(max-width: 600px)" srcset="{{$post.image}}">
                        <!--Tablet and above Image-->
                        <source media="(min-width: 601px)" srcset="{{$post.image}}">
                        <img loading="lazy" decoding="async" src="{{$post.image}}" alt="stylist" width="413" height="480">
                    {{else}}
                        <!--Mobile Image-->
                        <source media="(max-width: 600px)" srcset="{{$default_img}}">
                        <!--Tablet and above Image-->
                        <source media="(min-width: 601px)" srcset="{{$default_img}}">
                        <img loading="lazy" decoding="async" src="{{$default_img}}" alt="stylist" width="413" height="480">
                    {{/if}}
                </picture>
                <div class="cs-info">
                    <span class="cs-date">
                        <img class="cs-icon" loading="lazy" decoding="async" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/calendar.svg" alt="stylist" width="20" height="20">
                        {{date('d M, Y', $post.created)}}
                    </span>
                    {{if $post.title}}
                        <h3 class="cs-h3"><a href="{{$post.mid}}">{{$post.title}}</a></h3>
                    {{/if}}
                    <span class="cs-desc">
                        {{$post.blurb}}
                    </span>
                    <a href="{{$post.mid}}" class="cs-link">Read More</a>
                </div>
            </li>
        {{/foreach}}
        </ul>
    </div>
</section>
