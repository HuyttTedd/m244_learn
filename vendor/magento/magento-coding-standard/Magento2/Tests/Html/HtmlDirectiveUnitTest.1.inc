<!--
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
-->
<!--@vars {
"var foo.good":"Some variable",
"var foo.good|stillfine":"Some variable",
"var foo.bad()":"Some variable",
"var foo.bad()|alsobad":"Some variable",
"var foo.getGood()":"Some variable",
"var foo.foo.getGood()":"Some variable",
"var foo.getGood().fine":"Some variable",
"var foo.getGood().fine|alsofine":"Some variable",
"var foo.bad($bad.param())":"Some variable",
"var foo.bad.baz()":"Some variable",
"var foo.good.trans":"Some variable",
"var extra.var.getOhNo()":"Uh Oh, Error time!",
"var foo.bad.trans()":"Some variable",
"var bad.bad()":"Some variable",
"var foo.goodif":"Some Variable",
"var foo.goodif":"Some Variable",
"var foo.badif().bad":"Some Variable",
"var foo.badif3()":"Some Variable",
"var foo.gooddepend":"Some Variable",
"var foo.badDepend().bad":"Some Variable",
"var foo.goodFor":"Some Variable",
"var foo.getGoodFor()":"Some Variable",
"var foo.badForLoop()":"Some Variable",
"var foo.goodif2":"Some Variable",
"var foo.goodif2":"Some Variable",
"var foo.goodif3":"Some Variable",
"var foo.badif2()":"Some Variable",
"var foo.badif4()":"Some Variable",
"var foo.badif5()":"Some Variable",
"var foo.gooddepend2":"Some Variable",
"var foo.baddepend2()":"Some Variable",
"var foo.goodFor":"Some Variable",
"var foo.goodFor|stillfine":"Some Variable",
"var foo.badFor()":"Some Variable",
"var foo.badFor()|alsobad":"Some Variable",
"foobar baz":"Some other directive as a variable",
"var iusefilterslater|raw":"Some Variable",
"var bad.multiline()":""
} @-->

<div>{{var foo.good}}</div>
<div>{{var foo.good|stillfine}}</div>
<div>{{var foo.bad()}}</div>
<div>{{var foo.bad()|alsobad}}</div>
<div>{{var foo.getGood()}}</div>
<div>{{var foo.foo.getGood()}}</div>
<div>{{var foo.getGood().fine}}</div>
<div>{{var foo.getGood().fine|alsofine}}</div>
<div>{{var foo.bad($bad.param())}}</div>
<div>{{var foo.bad.baz()}}</div>
<div>{{var foo.undeclared.baz}}</div>
<div>{{trans "foo %bar" bar=$foo.good.trans}}</div>
<div>{{trans "foo %bar" bar=$foo.bad.trans()}}</div>
<div>{{trans "foo %bar" bar="something"}}</div>
<div>{{trans "foo %bar" bar="something" bad="$bad.bad()" something=$undeclared.var.error}}</div>
<div>{{something "
    <blah>foo %bar</blah>blah
    " bar="something"
    }}</div>
<div>{{something "
    <blah>foo %bar</blah>blah
    " bar="something" bad=$bad.multiline()
    }}</div>

{{if foo.goodif}}
<div>{{var foo.goodif2}}</div>
{{/if}}

{{if foo.goodif}}
<div>{{var foo.goodif2}}</div>
{{else}}
<div>{{var foo.goodif3}}</div>
{{/if}}

{{if foo.badif().bad}}
<div>{{var foo.badif2()}}</div>
{{/if}}

{{if foo.badif3()}}
<div>{{var foo.badif4()}}</div>
{{else}}
<div>{{var foo.badif5()}}</div>
{{/if}}

{{depend foo.gooddepend}}
<div>{{var foo.gooddepend2}}</div>
{{/depend}}

{{depend foo.badDepend().bad}}
<div>{{var foo.baddepend2()}}</div>
{{/depend}}

{{for item in foo.goodFor}}
<div>{{var foo.goodFor}}</div>
<div>{{var foo.goodFor|stillfine}}</div>
<div>{{var foo.badFor()}}</div>
<div>{{var foo.badFor()|alsobad}}</div>
{{/for}}

{{for item in foo.getGoodFor()}}
<div>loopy</div>
{{/for}}

{{for item in foo.badForLoop()}}
<div>this loop has a bad variable</div>
{{/for}}

{{depend iusefilterslater}}
{{var iusefilterslater|raw}}
{{/depend}}
