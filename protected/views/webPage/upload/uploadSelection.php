<h3>uploadSelection</h3>
    <?php
        $_upload = ItemFilter::get($upload->id, $upload);
        echo $this->renderPartial('/webPage/upload/'.$_upload->type, array(
            'upload'=>$_upload,
            'parser'=>new MarkdownParserHighslide(),
        ));
    ?>


