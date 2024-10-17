<style>
          :root {
                    --loader-color: rgba(0, 0, 0, 0.5);
          }

          .dark-theme {
                    --loader-color: rgba(255, 255, 255, 0.5);
          }

          /* Loader */
          .loader {
                    display: flex;
                    align-items: center;
          }

          .bar {
                    display: inline-block;
                    width: 3px;
                    height: 12px;
                    background-color: var(--loader-color);
                    border-radius: 10px;
                    animation: scale-up4 1s linear infinite;
          }

          .bar:nth-child(2) {
                    height: 20px;
                    margin: 0 5px;
                    animation-delay: .25s;
          }

          .bar:nth-child(3) {
                    animation-delay: .5s;
          }

          @keyframes scale-up4 {
                    20% {
                              background-color: var(--text-color);
                              transform: scaleY(1.5);
                    }

                    40% {
                              transform: scaleY(1);
                    }
          }
</style>
<div class="loader m-2" style="display: none;">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
</div>