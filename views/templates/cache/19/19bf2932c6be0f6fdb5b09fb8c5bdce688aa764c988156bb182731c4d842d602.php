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

/* confirmdeletearticle.html.twig */
class __TwigTemplate_53b5d3b1b5d6e692b628fae0522d4a7a3092061c4edb3663b0a3c5fff3a0cf3c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "baselog.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("baselog.html.twig", "confirmdeletearticle.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Erreur";
    }

    // line 6
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        echo "<div class=\"jumbotron text-center\"><br><br>
   
    <h1>
        Vous êtes sur le point de supprimer l'article : ";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["article"] ?? null), "titre", [], "any", false, false, false, 10), "html", null, true);
        echo " 
    </h1>
</div>

<div class=\"container\">
    <div class=\"row justify-content-center text-center\">
        <div class=\"col-6\"><br>
            <div class=\" card mb-4\">
                <div class=\"card-body\">
                    <p class=\"card-text\">Voulez-vous vraiment supprimer?</p>
                    <a href=\"index.php?action=deleteArticle&amp;id=";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["article"] ?? null), "id", [], "any", false, false, false, 20), "html", null, true);
        echo "\"><button type=\"button\" class=\"btn btn-sm btn-outline-secondary\">Supprimer</button></a>
                    <p class=\"card-text\">Retour à la liste des articles</p>
                    <a href=\"index.php?action=listArticlesAdmin\"><button type=\"button\" class=\"btn btn-sm btn-outline-secondary\">Supprimer</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "confirmdeletearticle.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 20,  63 => 10,  58 => 7,  54 => 6,  47 => 4,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "confirmdeletearticle.html.twig", "C:\\wamp64\\www\\projet5_DA\\views\\templates\\security\\confirmdeletearticle.html.twig");
    }
}
