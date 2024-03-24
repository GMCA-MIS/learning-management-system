    <style>
     @import 'https://unpkg.com/open-props' layer(design.system);
@import 'https://unpkg.com/open-props/normalize.light.min.css'
  layer(base.normalize);

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@200..900&display=swap');

@layer base.carousel {
  section {
    container-type: inline-size;
    display: grid;
    place-items: center;
    gap: var(--size-7);
    inline-size: 100%;
    background-color: #241510;
    color: white;
    padding-block: var(--size-7);
    padding-inline: var(--size-3);
  }

  .carousel {
    display: grid;
    max-inline-size: 1600px;
    gap: var(--size-3);
  }

  header {
    display: grid;
    grid-auto-flow: column;
    justify-content: space-between;
  }

  h3 {
    font-weight: var(--font-weight-7);
  }

  .controls {
    direction: ltr;
    display: grid;
    grid-auto-flow: column;
    place-items: center;
    gap: 0.75rem;

    @media (width < 768px) {
      display: none;
    }
  }
  button {
    display: grid;
    place-items: center;
    inline-size: var(--size-8);
    block-size: var(--size-8);
    border-radius: var(--radius-round);
    background-color: var(--gray-3);
    transition: background-color 0.2s ease;

    &:hover {
      background-color: var(--gray-4);
    }

    &:focus {
      box-shadow: 0 0 0 2px var(--indigo-7);
    }

    &:focus-visible {
      box-shadow: unset;
      outline-offset: unset;
    }

    &:disabled {
      opacity: 0.3;
      cursor: not-allowed;
    }
  }

  .scroller {
    display: grid;
    grid-auto-flow: column;
    gap: var(--size-3);
    scroll-behavior: smooth;
    overflow-x: auto;
    padding-block-end: var(--size-6);
    scrollbar-width: thin;
    overflow-x: auto;
    overscroll-behavior-x: contain;
    scroll-snap-type: x mandatory;
  }

  .snap {
    scroll-snap-align: start;
    padding: 0;
    margin: 0;
    text-decoration: none;
    color: inherit;
  }

  figure {
    display: grid;
    grid-template-rows: 1fr min-content;
    inline-size: min(100cqi, 500px);
    place-items: start;
    gap: var(--size-3);
  }

  img {
  aspect-ratio: 4 / 3; /* Set the aspect ratio as needed */
  object-fit: cover;
  background-color: white;
  block-size: auto; /* Let the browser calculate the height based on aspect ratio */
  inline-size: 100%; /* Set width to 100% of the viewport width */
  max-inline-size: 100%; /* Set maximum width to the width of two images */
  background-position:center;
}




  figcaption {
    font-size: var(--font-size-3);
    font-weight: var(--font-weight-5);
  }
}

@layer base.demo {
  /* just for demo */
  body {
    font-family: 'Inter', sans-serif;
    display: grid;
    place-items: center;
    background-color: #341c14;
  }
}
.overlay {
  position: relative;
}

.overlay::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 96%;
  background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.7) 100%);
}

/* Add text overlay */
.text-overlay {
 width: 100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 2vw; /* Responsive font size */
  text-align: center; /* Center text horizontally */
    font-family: 'Inter', sans-serif;
}

    </style>
    
    <section>
      <div
        class="carousel"
        aria-label="Featured Items Carousel"
        aria-roledescription="carousel"
      >
        <header>
          <h3>Other Campuses</h3>

          <div class="controls">
            <button
              id="prevBtn"
              aria-label="Previous"
              title="Previous"
              onclick="Scroller.scrollBy(-516, 0)"
            >
              <svg
                width="10"
                height="15"
                viewBox="0 0 10 15"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <path
                  d="M8.71833 15L0 7.5L8.71833 0L10 1.10257L2.56337 7.5L10 13.8974L8.71833 15Z"
                  fill="black"
                />
              </svg>
            </button>
            <button
              id="nextBtn"
              aria-label="Next"
              title="Next"
              onclick="Scroller.scrollBy(516, 0)"
            >
              <svg
                width="10"
                height="15"
                viewBox="0 0 10 15"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
              >
                <path
                  d="M1.28167 15L10 7.5L1.28167 0L1.72702e-07 1.10257L7.43663 7.5L1.72702e-07 13.8974L1.28167 15Z"
                  fill="black"
                />
              </svg>
            </button>
          </div>
        </header>

        <div
          id="Scroller"
          class="scroller"
          role="group"
          aria-label="Items Scroller"
          aria-live="polite"
        >
          <a
            href="#"
            class="snap"
            aria-label="1 of 6"
            aria-roledescription="item"
          >
            <figure class="overlay">
              <picture>
                <source
                  srcset="
                   ./images/gmc7.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc7.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div class="text-overlay">Golden Minds Colleges <br>Sta. Maria Bulacan</div>
              </figcaption>
            </figure>
          </a>
          <a
            href="#"
            class="snap"
            aria-label="2 of 6"
            aria-roledescription="item"
          >
            <figure>
              <picture>
                <source
                  srcset="
                    ./images/gmc2.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc2.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div></div>
              </figcaption>
            </figure>
          </a>
          <a
            href="#"
            class="snap"
            aria-label="3 of 6"
            aria-roledescription="item"
          >
            <figure class="overlay">
              <picture>
                <source
                  srcset="
                    ./images/gmc4.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc4.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div class="text-overlay">Golden Minds Colleges <br>Balagtas Bulacan</div>
              </figcaption>
            </figure>
          </a>
          <a
            href="#"
            class="snap"
            aria-label="4 of 6"
            aria-roledescription="item"
          >
            <figure>
              <picture>
                <source
                  srcset="
                    ./images/gmc3.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc3.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div></div>
              </figcaption>
            </figure>
          </a>
          <a
            href="#"
            class="snap"
            aria-label="5 of 6"
            aria-roledescription="item"
          >
            <figure class="overlay">
              <picture>
                <source
                  srcset="
                    ./images/gmc5.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc5.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div class="text-overlay">Golden Minds Colleges <br>Guguinto Bulacan</div>
              </figcaption>
            </figure>
          </a>
          <a
            href="#"
            class="snap"
            aria-label="6 of 6"
            aria-roledescription="item"
          >
            <figure>
              <picture>
                <source
                  srcset="
                    ./images/gmc6.jpg
                  "
                  type="image/avif"
                />
                <img
                  src="./images/gmc6.jpg"
                  alt=""
                  loading="lazy"
                  width="500"
                  height="500"
                />
              </picture>
              <figcaption>
                <div></div>
              </figcaption>
            </figure>
          </a>
        </div>
      </div>
    </section>

    <script>
     const lastElem = Scroller.lastElementChild;
const firstElem = Scroller.firstElementChild;

let isAtEnd;
let isAtStart;

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      isAtEnd = entry.isIntersecting && lastElem === entry.target;
      isAtStart = entry.isIntersecting && firstElem === entry.target;
      updateControls();
    });
  },
  { root: Scroller, threshold: 0.5 }
);

observer.observe(lastElem);
observer.observe(firstElem);

function updateControls() {
  // If the document direction is right-to-left (RTL), swap the values of isAtStart and isAtEnd
  if (document.firstElementChild.getAttribute('dir') === 'rtl')
    [isAtStart, isAtEnd] = [isAtEnd, isAtStart];

  if (document.activeElement === nextBtn && isAtEnd) {
    prevBtn.focus();
  } else if (document.activeElement === prevBtn && isAtStart) {
    nextBtn.focus();
  }

  nextBtn.toggleAttribute('disabled', isAtEnd);
  prevBtn.toggleAttribute('disabled', isAtStart);
}

    </script>