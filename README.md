<div id="top"></div>

<!-- [![Contributors][contributors-shield]][contributors-url] -->
<!-- [![Stargazers][stars-shield]][stars-url] -->
[![Forks][forks-shield]][forks-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<div align="center">

[//]: # (  <img src="images/logo.png" alt="Logo" width="80" height="80" />)
  <!-- https://drive.google.com/uc?export=view&id=      => Google drive Link -->

<h2 align="center">Readify Api</h2>

  <p align="center">
    Real life library api
    <br />
    <!-- <a href="https://github.com/JulesEfrei/readify-api"><strong>Explore the docs</strong></a> -->
    <br />
    <br />
    <!-- <a href="https://github.com/JulesEfrei/readify-api">View Demo</a>
    · -->
    <a href="https://github.com/JulesEfrei/readify-api/issues">Report Bug</a>
    ·
    <a href="https://github.com/JulesEfrei/readify-api/pulls">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap / Features</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#credit">Credit</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

[//]: # ([![Product Name Screen Shot][product-screenshot]])

Readify-Api is an API to manage a network of library and book related to where user can search for a book, see where the book is available and borrow or reserve it.

/* This project was created for educational purposes  */

* State of the Project => Pre-release v.0.8.0
* Main difficulties - [Roadmap](#roadmap)


<p align="right">(<a href="#top">back to top</a>)</p>



### Built With

This section should list any major frameworks/libraries used to bootstrap your project.

* [Symfony](https://symfony.com/)
* [ApiPlatform](https://api-platform.com/)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- GETTING STARTED -->
## Getting Started

This is an example of how you may give instructions on setting up your project locally.
To get a local copy up and running follow these simple example steps.


### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/JulesEfrei_/readify-api.git
   ```
2. Start the application with docker
   ```sh
   docker compose up -d
   ```
3. Setup the migrations & load fixtures
   ```sh
    docker compose exec app php bin/console doctrine:migrations:migrate -n 
    docker compose exec app php bin/console doctrine:fixtures:load # (Optionnal) 
   ```

<p align="right">(<a href="#top">back to top</a>)</p>


## Usage

1. Start the project with docker
   ```sh
   docker compose up -d
   ```
2. Navigate to [**localhost:8000/api**](localhost:8000/api) to see the documentation of the API

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

Here is the roadmap of the project. Checked flags mean the features is out and unchecked flags mean that the feature is comming.

- [x] JWT Authentication
- [x] CRUD on all entities
- [x] Boosted reviews
- [x] Multi copy book management
- [x] Borrow system
- [x] Basic filter
- [x] Access to sub-resources
- [x] Get status of a book
- [ ] Advanced search
  - [ ] User history
- [ ] Reservation system
- [ ] Reminders (for borrow and reservation)
- [ ] Book statistic


See the [open issues](https://github.com/JulesEfrei/readify-api/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- Credit -->
## Credit

List of people

* [Me](https://github.com/JulesEfrei)
* [Romain](https://github.com/RoromainM)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Linked'in - [Jules](https://www.linkedin.com/in/jules-bruzeau/)

GitHub Profile: [JulesEfrei](https://github.com/JulesEfrei/)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information. If no license is available in the repository, it will be available one day, I hope.

<p align="right">(<a href="#top">back to top</a>)</p>






<!-- MARKDOWN LINKS & IMAGES -->
<!-- [contributors-shield]: https://img.shields.io/github/contributors/JulesEfrei/readify-api.svg?style=for-the-badge
[contributors-url]: https://github.com/JulesEfrei/readify-api/graphs/contributors -->
<!-- [stars-shield]: https://img.shields.io/github/stars/JulesEfrei/readify-api.svg?style=for-the-badge
[stars-url]: https://github.com/JulesEfrei/readify-api/stargazers -->
[forks-shield]: https://img.shields.io/github/forks/JulesEfrei/readify-api.svg?style=for-the-badge
[forks-url]: https://github.com/JulesEfrei/readify-api/network/members
[issues-shield]: https://img.shields.io/github/issues/JulesEfrei/readify-api.svg?style=for-the-badge
[issues-url]: https://github.com/JulesEfrei/readify-api/issues
[license-shield]: https://img.shields.io/github/license/JulesEfrei/readify-api.svg?style=for-the-badge
[license-url]: https://github.com/JulesEfrei/readify-api/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/jules-bruzeau/
[product-screenshot]: images/screenshot.png
