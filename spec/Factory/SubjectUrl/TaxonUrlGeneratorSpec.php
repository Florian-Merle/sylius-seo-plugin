<?php

namespace spec\Dedi\SyliusSEOPlugin\Factory\SubjectUrl;

use Dedi\SyliusSEOPlugin\Domain\SEO\Adapter\RichSnippetSubjectInterface;
use Dedi\SyliusSEOPlugin\Domain\SEO\Model\Subject\HomepageRichSnippetSubject;
use Dedi\SyliusSEOPlugin\Factory\SubjectUrl\TaxonUrlGenerator;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\TaxonInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class TaxonUrlGeneratorSpec extends ObjectBehavior
{
    function let(RouterInterface $router)
    {
        $this->beConstructedWith($router);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TaxonUrlGenerator::class);
    }

    function it_can_handle_valid_subjet()
    {
        $subject = \Mockery::mock(TaxonInterface::class, RichSnippetSubjectInterface::class);

        $this->can($subject)->shouldReturn(true);
    }

    function it_can_t_handle_invalid_subjet(HomepageRichSnippetSubject $subject)
    {
        $this->can($subject)->shouldReturn(false);
    }

    function it_generates_url(RouterInterface $router)
    {
        $subject = \Mockery::mock(TaxonInterface::class, RichSnippetSubjectInterface::class);

        $subject->shouldReceive(['getSlug' => 'my_slug']);

        $router->generate('sylius_shop_product_index', ['slug' => 'my_slug'], UrlGeneratorInterface::ABSOLUTE_URL)->willReturn('my_route');

        $this->generateUrl($subject)->shouldReturn('my_route');
    }
}
