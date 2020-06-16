<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* baselog.html.twig */
class __TwigTemplate_b531ae898a0f3be8262d8978677f0520754a185ae995c564cf7549aa3c3b87ee extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'stylesheets' => [$this, 'block_stylesheets'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\">
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        
        <link href=\"https://fonts.googleapis.com/css?family=Montserrat:400,700\" rel=\"stylesheet\" type=\"text/css\">
        <link href=\"https://fonts.googleapis.com/css?family=Pinyon+Script\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic\" rel=\"stylesheet\" type=\"text/css\">
        <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.8.1/css/all.css\" integrity=\"sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf \" crossorigin=\"anonymous\">
        <link rel=\"stylesheet\" href=\"../publics/css/style.css\">
        <link rel=\"stylesheet\"
        href=\"https://bootswatch.com/4/flatly/bootstrap.min.css\">
        ";
        // line 14
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 15
        echo "      
    </head>
    
    <body>
      <nav class=\"navbar navbar-expand-lg navbar-dark bg-primary fixed-top\">
        <a class=\"navbar-brand\" href=\"index.php?action=homePage\">Mon Blog</a>
        <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarColor01\" aria-controls=\"navbarColor01\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
          <span class=\"navbar-toggler-icon\"></span>
        </button>
        <div class=\"collapse navbar-collapse\" id=\"navbarColor01\">
          <ul class=\"navbar-nav mr-auto\">
            <li class=\"nav-item active\">
              <a class=\"nav-link\" href=\"index.php?action=homePage\"><span><i class=\"fa fa-home\"></i> Accueil</span></a>
            </li>
            
            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"index.php?action=listArticles\">Articles</a>
            </li>
            ";
        // line 33
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "pseudo", [], "any", false, false, false, 33)) {
            // line 34
            echo "            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"index.php?action=diplayprofil&amp;id=";
            // line 35
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "id", [], "any", false, false, false, 35), "html", null, true);
            echo "\">Profil</a>
            </li>
            ";
        } else {
            // line 38
            echo "            </li>
           <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"index.php?action=displFormulContact\">Inscription</a>
            </li>
            ";
        }
        // line 43
        echo "            ";
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "pseudo", [], "any", false, false, false, 43)) {
            // line 44
            echo "            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"index.php?action=logout\">Déconnexion</a>
            </li>
            ";
        } else {
            // line 48
            echo "            <li class=\"nav-item\">
              <a class=\"nav-link\" href=\"index.php?action=displConnexion\">Connexion</a>
            </li>
            ";
        }
        // line 52
        echo "          </ul>
          <span class=\" text-white\">";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "pseudo", [], "any", false, false, false, 53), "html", null, true);
        echo "</span>
          ";
        // line 54
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "pseudo", [], "any", false, false, false, 54)) {
            // line 55
            echo "          <img class=\" reveal-dev pic \" width=\"50\" src=\"../publics/img/users/avatar/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "avatar", [], "any", false, false, false, 55), "html", null, true);
            echo "\" alt=\"photo utilisateur\">
          ";
        } else {
            // line 57
            echo "          <img class=\" reveal-dev pic \" width=\"50\" src=\"../publics/img/franck.jpg\" alt=\"photo franck\">
          ";
        }
        // line 59
        echo "        </div>
      </nav>
          ";
        // line 61
        $this->displayBlock('body', $context, $blocks);
        // line 62
        echo "         
        
        
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class=\"scroll-to-top d-lg-none position-fixed \">
      <a class=\"js-scroll-trigger d-block text-center text-white rounded\" href=\"#page-top\">
          <i class=\"fa fa-chevron-up\"></i>
      </a>
  </div>
  
<script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\" integrity=\"sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj\" crossorigin=\"anonymous\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js\" integrity=\"sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo\" crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js\" integrity=\"sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI\" crossorigin=\"anonymous\"></script>
</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Mon blog";
    }

    // line 14
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 61
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "baselog.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  170 => 61,  164 => 14,  157 => 5,  138 => 62,  136 => 61,  132 => 59,  128 => 57,  122 => 55,  120 => 54,  116 => 53,  113 => 52,  107 => 48,  101 => 44,  98 => 43,  91 => 38,  85 => 35,  82 => 34,  80 => 33,  60 => 15,  58 => 14,  46 => 5,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "baselog.html.twig", "C:\\wamp64\\www\\projet5_DA\\views\\templates\\security\\baselog.html.twig");
    }
}
