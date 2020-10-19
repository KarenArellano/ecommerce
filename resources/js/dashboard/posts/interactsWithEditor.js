import EditorJS from '@editorjs/editorjs';
import Checklist from '@editorjs/checklist';
import Delimiter from '@editorjs/delimiter';
import Embed from '@editorjs/embed';
import Header from '@editorjs/header';
import ImageTool from '@editorjs/image';
import InlineCode from '@editorjs/inline-code';
import List from '@editorjs/list';
import Marker from '@editorjs/marker';
import Quote from '@editorjs/quote';
import Table from '@editorjs/table';
import Warning from '@editorjs/warning';
import Notifier from 'codex-notifier';


const post = {
    holder: 'content-editor',
    content: document.getElementById('post-content')
};

if (document.getElementById(post.holder)) {
    const editor = new EditorJS({
        logLevel: 'ERROR',
        holder: post.holder,
        placeholder: '...',
        tools: {
            paragraph: {
                config: {
                    placeholder: '...'
                }
            },
            header: {
                class: Header,
                inlineToolbar: ['link'],
                config: {
                    placeholder: 'Encabezado'
                },
                toolbox: {
                    title: 'Encabezado'
                },
            },
            image: {
                class: ImageTool,
                inlineToolbar: true,
                config: {
                    buttonContent: `<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.15 13.628A7.749 7.749 0 0 0 10 17.75a7.74 7.74 0 0 0 6.305-3.242l-2.387-2.127-2.765 2.244-4.389-4.496-3.614 3.5zm-.787-2.303l4.446-4.371 4.52 4.63 2.534-2.057 3.533 2.797c.23-.734.354-1.514.354-2.324a7.75 7.75 0 1 0-15.387 1.325zM10 20C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10z"></path>
                    </svg> Seleccionar Imagen`,
                    captionPlaceholder: 'Pie de la imagen',
                    endpoints: {
                        byFile: window.location.href.replace('edit', 'attach/image'),
                        byUrl: window.location.href.replace('edit', 'attach/image'),
                    },
                    additionalRequestHeaders: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                },
                toolbox: {
                    title: 'Imagen'
                },
            },
            list: {
                class: List,
                inlineToolbar: true,
                toolbox: {
                    title: 'Listas'
                },
            },
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: {
                    quotePlaceholder: 'Ingresa un cita',
                    captionPlaceholder: 'Autor de la cita',
                },
                toolbox: {
                    title: 'Cita'
                },
            },
            warning: {
                class: Warning,
                inlineToolbar: true,
                toolbox: {
                    title: 'Nota'
                },
            },
            marker: {
                class: Marker,
                inlineToolbar: true,
                toolbox: {
                    title: 'subrayado'
                },
            },
            delimiter: {
                class: Delimiter,
                inlineToolbar: true,
                toolbox: {
                    title: 'Separador'
                },
            },
            inlineCode: InlineCode,
            embed: {
                class: Embed,
                inlineToolbar: true,
                config: {
                    services: {
                        youtube: true,
                        coub: true
                    }
                },
            },
            table: {
                class: Table,
                inlineToolbar: true,
                toolbox: {
                    title: 'Tabla'
                },
            },
        },
        data: {
            blocks: JSON.parse(post.content.value)
        },
        onChange: function () {
            editor.save().then((content) => {
                let updatePostUrl = window.location.href.replace('edit', '');

                let postContentBlocks = {
                    content: content.blocks,
                    partial: 1
                };

                axios.put(updatePostUrl, postContentBlocks).then(function (response) {
                    Notifier.show({
                        style: 'success',
                        message: 'Guardando...',
                        time: 1000
                    });
                }).catch(function (error) {
                    console.log(error.response);

                    Notifier.show({
                        style: 'error',
                        message: error.response,
                    });
                });
            }).catch((error) => {
                console.log('Saving failed: ', error)

                Notifier.show({
                    style: 'error',
                    message: error,
                    time: 1000
                });
            });
        }
    });
}