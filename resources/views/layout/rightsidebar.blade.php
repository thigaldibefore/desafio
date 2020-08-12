<nav class="am-right-sidebar">
    <div class="sb-content">
        <div class="user-info">
            <img src="{{ \Auth::user() ? asset(\Auth::user()->avatar) : '' }}">
            <span class="name">{{Auth::user()->name}}<span class="status"></span></span>
        <div class="tab-panel">
            <div class="tab-content">
                <div class="tab-pane chat active" id="tab2" role="tabpanel">
                    <div class="chat-contacts">
                        <div class="chat-sections">
                            <div class="am-scroller-chat">
                                <div class="content">
                                    <h2>Membros</h2>
                                    <div class="contact contact right-members-content">
                                        <div class="user"><a href="#">
                                                <div class="user-data2"><span class="name">carregando ...</span></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>