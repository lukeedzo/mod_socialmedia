const convertSVGsToInline = (parentClass) => {
  const parentElements = document.querySelectorAll(parentClass);
  parentElements.forEach((parentElement) => {
    const svgElements = parentElement.querySelectorAll('img[src$=".svg"]');
    svgElements.forEach((svgElement) => {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', svgElement.getAttribute('src'), true);
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const svgData = xhr.responseText;
          const parser = new DOMParser();
          const svgNode = parser.parseFromString(
            svgData,
            'image/svg+xml'
          ).documentElement;
          Array.from(svgElement.attributes).forEach((attr) => {
            if (attr.name !== 'src') {
              svgNode.setAttribute(attr.name, attr.value);
            }
          });
          svgElement.parentNode.replaceChild(svgNode, svgElement);
        }
      };
      xhr.send();
    });
  });
};

export { convertSVGsToInline };
