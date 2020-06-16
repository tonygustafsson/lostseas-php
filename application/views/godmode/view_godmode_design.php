<div class="container">
    <h3>God mode: Design</h3>

    <div class="button-area">
        <a class="ajaxHTML button big-icon" title="Change user parameters"
            href="godmode/user/<?=$this->uri->segment(3)?>">
            <svg width="32" height="32" alt="User">
                <use xlink:href="#player"></use>
            </svg>
            User
        </a>
        <a class="ajaxHTML button big-icon" title="Change game parameters"
            href="godmode/index/<?=$this->uri->segment(3)?>">
            <svg width="32" height="32" alt="User">
                <use xlink:href="#swords"></use>
            </svg>
            Game
        </a>
        <a class="ajaxHTML button big-icon" title="Change ship parameters"
            href="godmode/ship/<?=$this->uri->segment(3)?>">
            <svg width="32" height="32" alt="Ships">
                <use xlink:href="#ship"></use>
            </svg>
            Ships
        </a>
        <a class="ajaxHTML button big-icon" title="Change crew parameters"
            href="godmode/crew/<?=$this->uri->segment(3)?>">
            <svg width="32" height="32" alt="Crew">
                <use xlink:href="#crew-man"></use>
            </svg>
            Crew
        </a>
        <a class="ajaxHTML button big-icon" title="View design system"
            href="godmode/design/<?=$this->uri->segment(3)?>">
            <svg width="32" height="32" alt="Crew">
                <use xlink:href="#design"></use>
            </svg>
            Design
        </a>
    </div>

    <h3>Buttons</h3>

    <button>Default</button>

    <button class="primary">Primary</button>

    <button disabled>Disabled</button>

    <button class="big">Big</button>

    <a href="#" class="button">Button link</a>

    <button>
        <svg width="32" height="32" alt="Icon">
            <use xlink:href="#food"></use>
        </svg>
        Icon
    </button>

    <button class="big-icon">
        <svg width="32" height="32" alt="Icon">
            <use xlink:href="#swords"></use>
        </svg>
        Big icon
    </button>

    <button class="big-image">
        <img
            src="<?=base_url('assets/images/tavern/tavern-dinner.png')?>" />
        Image
    </button>

    <h3>Button area</h3>

    <div class="button-area">
        <button class="big">Big</button>
        <button class="big">Big</button>
        <button class="big">Big</button>
        <button class="big primary">Primary</button>
    </div>

    <h1>Heading 1</h1>
    <h2>Heading 2</h2>
    <h3>Heading 3</h3>
    <h4>Heading 4</h4>

    <h2>Paragraph</h2>

    <p>Lorem Ipsum is <strong>simply</strong> dummy text of the printing and <em>typesetting industry</em>.
        Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make
        a
        type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
        Lorem Ipsum passages, <em>and more recently with desktop</em> publishing software like Aldus PageMaker including
        versions of
        Lorem Ipsum.</p>

    <h2>Quote</h2>

    <blockquote>
        The time to start sailing is always today, not tomorrow.
    </blockquote>

    <h2>Lists</h2>

    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
    </ul>
</div>