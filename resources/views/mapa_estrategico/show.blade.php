@role('admin')
@if(Auth::user()->Empresa->id == Request()->empresa)
    @extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="row ">
            <a href="{{route('proceso.show',[Request()->empresa,Request()->proceso])}}" class="btn btn-dark" role="button" aria-pressed="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                </svg>
                Regresar
            </a>
        </div>
        <div class="row justify-content-center ">
            <div class="color-titulo mb-4 mt-2" style="font-size: 30px">
                <i class="fas fa-briefcase color-icono"></i>
                <span class="font-weight-bold ml-3" > {{$data->nombre}} </span>
            </div>
        </div>
        <div class="row ">
            <div class="container">

                <div class="row mt-4">
                    <div class="col-10">

                    </div>
                    <div class="col-2 mb-3">
                        <a href="{{route('estrategia.create',[Request()->empresa,Request()->proceso,Request()->mapa_estrategico])}}" class="btn btn-primary" role="button" aria-pressed="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Estrategia
                        </a>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">

                        <table class="table mb-5">

                            <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Perspectiva</th>
                                <th scope="col">Relacion</th>
                                <th scope="col">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->estrategias as $elem)

                                <tr>
                                    <td>
                                        {{$elem->nombre}}
                                    </td>
                                    <td>
                                        {{$elem->perspectiva->nombre}}
                                    </td>
                                    <td>
                                        {{$elem->relacion->nombre}}
                                    </td>
                                    <td>
                                        <div class="color-titulo row" style="font-size: 25px">

                                            <a href="{{route('estrategia.edit',[
                                                            Request()->empresa,
                                                            Request()->proceso,
                                                            Request()->mapa_estrategico,
                                                            $elem->id
                                                            ])}}" class="col-4 p-0" aria-pressed="true"><i class="fas fa-pen-square btn-editar"></i>
                                            </a>
                                            <a  class="col-4 p-0" aria-pressed="true"><i class="fas fa-trash-alt btn-eliminar" aria-pressed="true" data-toggle="modal" data-target="#exampleModal{{$elem->id}}"></i>
                                            </a>

                                            <div class="modal fade" id="exampleModal{{$elem->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Borrado</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Seguro que desea borrar esta estrategia ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            {!! Form::open(['action' => ['EstrategiaController@destroy',Request()->empresa,Request()->proceso,Request()->mapa_estrategico,$elem->id],'method'=>'POST']) !!}
                                                            {{Form::hidden('_method','DELETE')}}
                                                            {{Form::submit('Borrar',['class'=>'btn btn-dark'])}}
                                                            {!! Form::close() !!}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="row my-5">
                    <div class="col-8 mb-5"></div>
                    <div class="col-2">
                        <a href="#" onclick="generate()" class="btn btn-dark   btn-block" role="button" aria-pressed="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-word-fill" viewBox="0 0 16 16">
                                <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5.485 4.879l1.036 4.144.997-3.655a.5.5 0 0 1 .964 0l.997 3.655 1.036-4.144a.5.5 0 0 1 .97.242l-1.5 6a.5.5 0 0 1-.967.01L8 7.402l-1.018 3.73a.5.5 0 0 1-.967-.01l-1.5-6a.5.5 0 1 1 .97-.242z"/>
                            </svg>
                            Export Word
                        </a>
                    </div>
                    <div class="col-2">

                        <a href="#" class="btn btn-main btn-block" role="button" aria-pressed="true"  onclick="generarPDF()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-code-fill" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.646 7.646a.5.5 0 1 1 .708.708L5.707 10l1.647 1.646a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2zm2.708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 10 8.646 8.354a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                            Export PDF

                        </a>

                    </div>
                    <div class="col-12 mt-5">
                    <div id="diagram" style="width: 100%; height: 110vh;">
                    </div>
                    </div><div class="col-12 mt-5">
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section("js")
    <script src="https://unpkg.com/gojs/release/go.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

    <script>
        function toInt32(bytes) {
            return (bytes[0] << 24) | (bytes[1] << 16) | (bytes[2] << 8) | bytes[3];
        }

        function getDimensions(data) {
            return {
                width: toInt32(data.slice(16, 20)),
                height: toInt32(data.slice(20, 24))
            };
        }

        var base64Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

        function base64Decode(data) {
            var result = [];
            var current = 0;

            for(var i = 0, c; c = data.charAt(i); i++) {
                if(c === '=') {
                    if(i !== data.length - 1 && (i !== data.length - 2 || data.charAt(i + 1) !== '=')) {
                        throw new SyntaxError('Unexpected padding character.');
                    }

                    break;
                }

                var index = base64Characters.indexOf(c);

                if(index === -1) {
                    throw new SyntaxError('Invalid Base64 character.');
                }

                current = (current << 6) | index;

                if(i % 4 === 3) {
                    result.push(current >> 16, (current & 0xff00) >> 8, current & 0xff);
                    current = 0;
                }
            }

            if(i % 4 === 1) {
                throw new SyntaxError('Invalid length for a Base64 string.');
            }

            if(i % 4 === 2) {
                result.push(current >> 4);
            } else if(i % 4 === 3) {
                current <<= 6;
                result.push(current >> 16, (current & 0xff00) >> 8);
            }

            return result;
        }

        function getPngDimensions(dataUri) {
            if (dataUri.substring(0, 22) !== 'data:image/png;base64,') {
                throw new Error('Unsupported data URI format');
            }

            // 32 base64 characters encode the necessary 24 bytes
            return getDimensions(base64Decode(dataUri.substr(22, 32)));
        }


        var myDiagram;
        function generarImagen() {

            var img = myDiagram.makeImage({
                scale: 1,

            });
            return img

        }
        function generate() {
            img = generarImagen();

            var dimensions = getPngDimensions(img.src);
            console.log(dimensions);
            const doc = new docx.Document({
                sections:[
                    {

                        children: [
                            new docx.Paragraph({
                                text: "Mapa Estrategico" ,
                                heading: docx.HeadingLevel.TITLE
                            }),
                            new docx.Paragraph({
                                text: `{{$data->proceso->empresa->nombre}} - {{$data->proceso->empresa->ruc}} - {{$data->proceso->empresa->direccion}}`
                            }),
                            new docx.Paragraph({
                                text: "Proceso : {{$data->proceso->nombre}}"
                            }),
                            new docx.Paragraph({
                                text: "Mapa de Proceso : {{$data->nombre}}"
                            }),
                            new docx.Paragraph({
                                text: "Usuario : {{Auth::user()->name}} - {{Auth::user()->email}}"
                            }),
                            new docx.Paragraph({
                                children:[
                                    new docx.ImageRun({
                                        data: img.src,
                                        transformation: {
                                            width: dimensions.width,
                                            height: dimensions.height,
                                        },
                                    }),

                                ]
                            }),

                        ]
                    }
                ]
            });

            docx.Packer.toBlob(doc).then(blob => {
                console.log(blob);
                saveAs(blob, "ejemplo.docx");
                console.log("doc generado correctamente");
            });
        }

        function generarPDF(){
            const doc = new jsPDF();
            doc.setFontSize(25);
            doc.text("Mapa Estrategico", 20, 10);
            doc.setFontSize(10);
            doc.text(`{{$data->proceso->empresa->nombre}} - {{$data->proceso->empresa->ruc}} - {{$data->proceso->empresa->direccion}}`, 20, 20);
            doc.text("Proceso : {{$data->proceso->nombre}}", 20, 25);
            doc.text("Mapa de Proceso : {{$data->nombre}}", 20, 30);
            doc.text("Usuario : {{Auth::user()->name}} - {{Auth::user()->email}}", 20, 35);
            img = generarImagen();
            doc.addImage(img.src, "png", 15, 40, 180, 180);
            doc.save("MapaEstrategico.pdf");
        }
        function init() {
            if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this

            var $ = go.GraphObject.make;  // for conciseness in defining templates

            myDiagram =
                $(go.Diagram, "diagram",  // create a Diagram for the DIV HTML element
                    {
                        layout: $(go.GridLayout,
                            { comparer: go.GridLayout.smartComparer ,
                                wrappingColumn : 1,
                                alignment : go.GridLayout.Position,
                                arrangement :go.GridLayout.RightToLeft,
                                cellSize : go.Size.parse("1 1"),
                                spacing : go.Size.parse("0 0"),

                            })
                        // other properties are set by the layout function, defined below
                    });

            // Define the appearance and behavior for Nodes:
            // First, define the shared context menu for all Nodes, Links, and Groups.
            // To simplify this code we define a function for creating a context menu button:
            function makeButton(text, action, visiblePredicate) {
                return $("ContextMenuButton",
                    $(go.TextBlock, text),
                    { click: action },
                    // don't bother with binding GraphObject.visible if there's no predicate
                    visiblePredicate ? new go.Binding("visible", "", function(o, e) { return o.diagram ? visiblePredicate(o, e) : false; }).ofObject() : {});
            }

            // a context menu is an Adornment with a bunch of buttons in them
            var partContextMenu =
                $("ContextMenu",
                    makeButton("Properties",
                        function(e, obj) {  // OBJ is this Button

                        }),

                );

            function nodeInfo(d) {  // Tooltip info for a node data object
                var str = "Node " + d.key + ": " + d.text + "\n";
                if (d.group)
                    str += "member of " + d.group;
                else
                    str += "top-level node";
                return str;
            }

            // These nodes have text surrounded by a rounded rectangle
            // whose fill color is bound to the node data.
            // The user can drag a node by dragging its TextBlock label.
            // Dragging from the Shape will start drawing a new link.
            myDiagram.nodeTemplate =
                $(go.Node, "Auto",
                    { locationSpot: go.Spot.Center },
                    $(go.Shape, "RoundedRectangle",
                        {
                            fill: "white", // the default fill, if there is no data bound value
                            portId: "", cursor: "pointer",  // the Shape is the port, not the whole Node
                            // allow all kinds of links from and to this port
                            fromLinkable: true, fromLinkableSelfNode: true, fromLinkableDuplicates: true,
                            toLinkable: true, toLinkableSelfNode: true, toLinkableDuplicates: true
                        },
                        new go.Binding("fill", "color")),
                    $(go.TextBlock,
                        {
                            font: "bold 14px sans-serif",
                            stroke: '#333',
                            margin: 15,  // make some extra space for the shape around the text
                            isMultiline: false,  // don't allow newlines in text
                            editable: false  // allow in-place editing by user
                        },
                        new go.Binding("text", "text").makeTwoWay()),  // the label shows the node data's text
                    { // this tooltip Adornment is shared by all nodes
                        toolTip:
                            $("ToolTip",
                                $(go.TextBlock, { margin: 4 },  // the tooltip shows the result of calling nodeInfo(data)
                                    new go.Binding("text", "", nodeInfo))
                            ),
                        // this context menu Adornment is shared by all nodes
                        contextMenu: partContextMenu
                    }
                );

            // Define the appearance and behavior for Links:

            function linkInfo(d) {  // Tooltip info for a link data object
                return "Link:\nfrom " + d.from + " to " + d.to;
            }

            // The link shape and arrowhead have their stroke brush data bound to the "color" property
            myDiagram.linkTemplate =
                $(go.Link,
                    { toShortLength: 3, relinkableFrom: false, relinkableTo: false },  // allow the user to relink existing links
                    $(go.Shape,
                        { strokeWidth: 2 },
                        new go.Binding("stroke", "color")),
                    $(go.Shape,
                        { toArrow: "Standard", stroke: null },
                        new go.Binding("fill", "color")),
                    { // this tooltip Adornment is shared by all links
                        toolTip:
                            $("ToolTip",
                                $(go.TextBlock, { margin: 4 },  // the tooltip shows the result of calling linkInfo(data)
                                    new go.Binding("text", "", linkInfo))
                            ),
                        // the same context menu Adornment is shared by all links
                        contextMenu: partContextMenu
                    }
                );

            // Define the appearance and behavior for Groups:

            function groupInfo(adornment) {  // takes the tooltip or context menu, not a group node data object
                var g = adornment.adornedPart;  // get the Group that the tooltip adorns
                var mems = g.memberParts.count;
                var links = 0;
                g.memberParts.each(function(part) {
                    if (part instanceof go.Link) links++;
                });
                return "Group " + g.data.key + ": " + g.data.text + "\n" + mems + " members including " + links + " links";
            }

            // Groups consist of a title in the color given by the group node data
            // above a translucent gray rectangle surrounding the member parts
            myDiagram.groupTemplate =
                $(go.Group, "Horizontal",
                    {
                        selectionObjectName: "PANEL",  // selection handle goes around shape, not label
                        ungroupable: true  ,// enable Ctrl-Shift-G to ungroup a selected Group
                        alignment : go.Spot.Left,
                    },
                    $(go.TextBlock,
                        {
                            //\alignment: go.Spot.Right,
                            font: "bold 19px sans-serif",
                            margin:10,
                            isMultiline: false,  // don't allow newlines in text
                            editable: false  // allow in-place editing by user
                        },
                        new go.Binding("text", "text").makeTwoWay(),
                        new go.Binding("stroke", "color")),
                    $(go.Panel, "Auto",
                        { name: "PANEL" },
                        $(go.Shape, "Rectangle",  // the rectangular shape around the members
                            {
                                fill: "#F4F6F9", stroke: "black", strokeWidth: 1,
                                portId: "", cursor: "pointer",  minSize : new go.Size(800,200), // the Shape is the port, not the whole Node
                                // allow all kinds of links from and to this port
                                fromLinkable: false, fromLinkableSelfNode: false, fromLinkableDuplicates: false,
                                toLinkable: false, toLinkableSelfNode: false, toLinkableDuplicates: false
                            }),
                        $(go.Placeholder, { margin: 10, background: "transparent" })  // represents where the members are
                    ),
                    { // this tooltip Adornment is shared by all groups
                        toolTip:
                            $("ToolTip",
                                $(go.TextBlock, { margin: 4 },
                                    // bind to tooltip, not to Group.data, to allow access to Group properties
                                    new go.Binding("text", "", groupInfo).ofObject())
                            ),
                        // the same context menu Adornment is shared by all groups
                        contextMenu: partContextMenu
                    }
                );

            // Define the behavior for the Diagram background:

            function diagramInfo(model) {  // Tooltip info for the diagram's model
                return "Model:\n" + model.nodeDataArray.length + " nodes, " + model.linkDataArray.length + " links";
            }

            // provide a tooltip for the background of the Diagram, when not over any Part
            myDiagram.toolTip =
                $("ToolTip",
                    $(go.TextBlock, { margin: 4 },
                        new go.Binding("text", "", diagramInfo))
                );

            // provide a context menu for the background of the Diagram, when not over any Part
            myDiagram.contextMenu =
                $("ContextMenu",
                );

            let allEstrategias = JSON.parse("{{ $data->estrategias->toJson() }}".replaceAll("&quot;",'"'));


            // Create the Diagram's Model:
            var nodeDataArray = [
                { key: "a1", text: "Financiera", color: "green", isGroup: true },
                { key: "a2", text: "Clientes", color: "#b1b109", isGroup: true },
                { key: "a3", text: "Procesos Negocio", color: "orange", isGroup: true },
                { key: "a4", text: "Aprendizaje y Conocimiento", color: "green", isGroup: true },

            ];
            for (let i = 0; i < allEstrategias.length; i++) {
                nodeDataArray.push({
                    key : allEstrategias[i].id,
                    text : allEstrategias[i].nombre,
                    group : "a"+allEstrategias[i].perspectiva_id,
                    color : allEstrategias[i].relacion.color,
                })
            }


            var linkDataArray = [

            ];

            for (let i = 0; i < allEstrategias.length; i++) {
                for (const estra in allEstrategias[i].estrategias) {
                    console.log(estra);
                    linkDataArray.push({
                        from : allEstrategias[i].estrategias[estra].estrategia_id,
                        to : allEstrategias[i].estrategias[estra].estrategia_to_id,

                    })

                }
            }
            console.log(nodeDataArray)
            console.log(linkDataArray)
            myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
        }



        window.onload = function() {
            init()
        };

    </script>
@endsection
@endif
@endrole
